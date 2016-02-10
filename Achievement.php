<?php

namespace Avoo\AchievementBundle;

use Avoo\AchievementBundle\Model\AchievementInterface;
use Avoo\AchievementBundle\Model\CategoryInterface;
use Avoo\AchievementBundle\Model\UserInterface;
use Avoo\AchievementBundle\Repository\AchievementRepository;
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
     * @var AchievementRepository $manager
     */
    protected $repository;

    /**
     * @var UserInterface|null $user
     */
    protected $user;

    /**
     * Construct
     *
     * @param TokenStorageInterface $security
     * @param EntityManager         $manager
     */
    public function __construct(TokenStorageInterface $security, EntityManager $manager)
    {
        if (null !== $token = $security->getToken()) {
            $this->user = $token->getUser();
        }

        $this->repository = $manager->getRepository('AvooAchievementBundle:Achievement');
    }

    /**
     * Get all achievements by category
     *
     * @param CategoryInterface|null $category
     *
     * @return AchievementInterface[]
     */
    public function getAll(CategoryInterface $category = null)
    {
        return $this->repository->getAchievements($category);
    }

    /**
     * Get locked achievements
     *
     * @param UserInterface $user
     *
     * @return AchievementInterface[]
     */
    public function getLockedAchievements(UserInterface $user)
    {
        return $this->repository->getLockedAchievements($user);
    }

    /**
     * Get unlocked achievements
     *
     * @param UserInterface $user
     *
     * @return AchievementInterface[]
     */
    public function getUnlockedAchievements(UserInterface $user)
    {
        return $this->repository->getUnlockedAchievements($user);
    }
}
