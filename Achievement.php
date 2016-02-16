<?php

namespace Avoo\AchievementBundle;

use Avoo\AchievementBundle\Checker\AchievementCheckerLocatorInterface;
use Avoo\AchievementBundle\Listener\AchievementListenerInterface;
use Avoo\AchievementBundle\Model\UserInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class Achievement
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class Achievement
{
    /**
     * @var UserInterface|null $user
     */
    protected $user;

    /**
     * @var AchievementCheckerLocatorInterface $checkerLocator
     */
    protected $checkerLocator;

    /**
     * Construct
     *
     * @param TokenStorageInterface              $security
     * @param EntityManager                      $manager
     * @param AchievementCheckerLocatorInterface $checkerLocator
     */
    public function __construct(
        TokenStorageInterface $security,
        EntityManager $manager,
        AchievementCheckerLocatorInterface $checkerLocator
    ) {
        if (null !== $token = $security->getToken()) {
            $this->user = $token->getUser();
        }

        $this->checkerLocator = $checkerLocator;
    }

    /**
     * Get achievement listener by key
     *
     * @param string $name
     *
     * @return AchievementListenerInterface
     */
    public function get($name)
    {
        return $this->checkerLocator->get($name);
    }

    /**
     * Get all achievements by category
     *
     * @param string|null $category
     *
     * @return AchievementListenerInterface[]
     */
    public function getAll($category = null)
    {
        $achievements = array_merge($this->getLockedAchievements($category), $this->getUnlockedAchievements($category));

        return $achievements;
    }

    /**
     * Get locked achievements
     *
     * @param string|null $category
     *
     * @return AchievementListenerInterface[]
     */
    public function getLockedAchievements($category = null)
    {
        $achievements = array();
        foreach ($this->checkerLocator->getTypes() as $achievement) {
            $listener = $this->get($achievement);

            if (!is_null($category) && $listener->getCategory() !== $category || is_null($listener->getUserAchievement())
            ) {
                continue;
            }

            if (is_null($listener->getUserAchievement()->getCompleteAt())) {
                $achievements[] = $listener;
            }
        }

        return $achievements;
    }

    /**
     * Get unlocked achievements
     *
     * @param string|null $category
     *
     * @return AchievementListenerInterface[]
     */
    public function getUnlockedAchievements($category = null)
    {
        if (!$this->user instanceof UserInterface) {
            return array();
        }

        $achievements = array();
        foreach ($this->checkerLocator->getTypes() as $achievement) {
            $listener = $this->get($achievement);

            if (!is_null($category) && $listener->getCategory() !== $category || is_null($listener->getUserAchievement())
            ) {
                continue;
            }

            if(!is_null($listener->getUserAchievement()->getCompleteAt())) {
                $achievements[] = $listener;
            }
        }

        return $achievements;
    }
}
