<?php

namespace Avoo\AchievementBundle;

use Avoo\AchievementBundle\Checker\AchievementCheckerLocatorInterface;
use Avoo\AchievementBundle\Listener\AchievementListenerInterface;
use Avoo\AchievementBundle\Model\UserInterface;
use Avoo\AchievementBundle\Repository\UserAchievementRepository;
use Doctrine\ORM\EntityManager;
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
     * @var UserAchievementRepository $repository
     */
    protected $repository;

    /**
     * @var array $categories
     */
    protected $categories;

    /**
     * Construct
     *
     * @param TokenStorageInterface              $security
     * @param EntityManager                      $manager
     * @param AchievementCheckerLocatorInterface $checkerLocator
     * @param string                             $repository
     * @param array                              $categories
     */
    public function __construct(
        TokenStorageInterface $security,
        EntityManager $manager,
        AchievementCheckerLocatorInterface $checkerLocator,
        $repository,
        $categories
    ) {
        $token = $security->getToken();
        if (null !== $token && is_object($user = $token->getUser())) {
            $this->user = $token->getUser();
        }

        $this->repository = $manager->getRepository($repository);
        $this->checkerLocator = $checkerLocator;
        $this->categories = $categories;
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
     * Get list of categories
     *
     * @return array
     */
    public function getCategories()
    {
        return array_unique($this->categories);
    }

    /**
     * Return number of earned achievements
     *
     * @param string $category
     *
     * @return array
     */
    public function getEarnedOverallAchievements($category = null)
    {
        $unlocked = count($this->getUnlockedAchievements($category));
        $total = count($this->checkerLocator->getTypes($category));

        return array(
            'unlocked' => $unlocked,
            'total' => $total,
            'percent' => $unlocked == 0 ? 0 : round($unlocked/$total*100)
        );
    }

    /**
     * Get latest achievements
     *
     * @param integer $limit
     *
     * @return AchievementListenerInterface[]
     */
    public function getLatestAchievements($limit = 1)
    {
        $achievements = array();
        if (is_null($this->user)) {
            return $achievements;
        }

        $userAchievements = $this->repository->getLatestAchievement($this->user, $limit);

        foreach ($userAchievements as $userAchievement) {
            $listener = $this->checkerLocator->get($userAchievement->getAchievement());
            $listener->setUserAchievement($userAchievement);
            $achievements[] = $listener;
        }

        return $achievements;
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
        $achievements = array_merge($this->getUnlockedAchievements($category), $this->getLockedAchievements($category));

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
        $tmp = array();
        foreach ($this->checkerLocator->getTypes($category) as $userAchievement) {
            $listener = $this->get($userAchievement);
            $progress = $listener->getUserAchievement()->getProgress();
            $total = $listener->getOptions()->getValue();

            if (is_null($listener->getUserAchievement()->getCompleteAt())) {
                $tmp[$listener->getOptions()->getId()] = (float) number_format($progress / $total * 100, 2);
            }
        }

        arsort($tmp);

        $achievements = array();
        foreach ($tmp as $achievementId => $progress) {
            $listener = $this->checkerLocator->get($achievementId);
            $achievements[] = $listener;
        }

        return $achievements;
    }

    /**
     * Get in progress achievements
     *
     * @return Model\UserAchievementInterface[]
     */
    public function getInProgressAchievements()
    {
        if (is_null($this->user)) {
            return array();
        }

        $types = $this->checkerLocator->getTypes();
        $userAchievements = $this->repository->findAchievements($this->user, $types, false);

        $tmp = array();
        foreach ($userAchievements as $userAchievement) {
            $listener = $this->checkerLocator->get($userAchievement->getAchievement());
            $listener->setUserAchievement($userAchievement);
            $progress = $listener->getUserAchievement()->getProgress();
            $total = $listener->getOptions()->getValue();
            $tmp[$listener->getOptions()->getId()] = (float) number_format($progress / $total * 100, 2);
        }

        arsort($tmp);

        $achievements = array();
        foreach ($tmp as $achievementId => $progress) {
            $listener = $this->checkerLocator->get($achievementId);
            $achievements[] = $listener;
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
        $types = $this->checkerLocator->getTypes($category);
        $userAchievements = $this->repository->findAchievements($this->user, $types, true);

        foreach ($userAchievements as $userAchievement) {
            $listener = $this->get($userAchievement->getAchievement());
            $listener->setUserAchievement($userAchievement);
            $achievements[] = $listener;
        }

        return $achievements;
    }
}
