<?php

namespace Avoo\AchievementBundle;

use Avoo\AchievementBundle\Checker\AchievementCheckerLocatorInterface;
use Avoo\AchievementBundle\Listener\AchievementListenerInterface;
use Avoo\AchievementBundle\Model\UserInterface;
use Avoo\AchievementBundle\Repository\UserAchievementRepository;
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
     * @var UserAchievementRepository $repository
     */
    protected $repository;

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

        $this->repository = $manager->getRepository('AvooAchievementBundle:UserAchievement');
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
     * @return array
     */
    public function getAll($category = null)
    {
        $types = $this->checkerLocator->getTypes();

        if (!is_null($category)) {
            $typesTmp = array();
            foreach ($types as $type) {
                if (false !== strpos($type, $category)) {
                    $typesTmp[] = $type;
                }
            }

            return $typesTmp;
        }

        return $types;
    }

    /**
     * Get locked achievements
     *
     * @return array
     */
    public function getLockedAchievements()
    {
        if (!$this->user instanceof UserInterface) {
            return array();
        }

        return $this->repository->getLockedAchievements($this->user);
    }

    /**
     * Get unlocked achievements
     *
     * @return array
     */
    public function getUnlockedAchievements()
    {
        if (!$this->user instanceof UserInterface) {
            return array();
        }

        return $this->repository->getUnlockedAchievements($this->user);
    }

    public function progress($name, $value)
    {
        $event = $this->checkerLocator->get($name);
    }

    public function verify($name, $object = null)
    {
        /** @var AchievementListenerInterface $event */
        $event = $this->checkerLocator->get($name);
        $event->verify($object);

        if ($event->isComplete()) {

        }
    }
}
