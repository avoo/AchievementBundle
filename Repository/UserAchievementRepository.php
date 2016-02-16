<?php

namespace Avoo\AchievementBundle\Repository;

use Avoo\AchievementBundle\Model\UserAchievementInterface;
use Avoo\AchievementBundle\Model\UserInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class UserAchievementRepository
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class UserAchievementRepository extends EntityRepository
{
    /**
     * Get achievement
     *
     * @param string             $id
     * @param UserInterface|null $user
     *
     * @return UserAchievementInterface|null
     * @throws NonUniqueResultException
     */
    public function getAchievement($id, $user = null)
    {
        if (is_null($user)) {
            return null;
        }

        $achievement = $this->createQueryBuilder('a')
            ->where('a.achievement = :achievement')
            ->andWhere('a.user = :user')
            ->setParameter('achievement', $id)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();

        return $achievement;
    }

    /**
     * Get locked achievements
     *
     * @param UserInterface $user
     *
     * @return array
     */
    public function getLockedAchievements(UserInterface $user)
    {

    }

    /**
     * Get unlocked achievements
     *
     * @param UserInterface $user
     *
     * @return array
     */
    public function getUnlockedAchievements(UserInterface $user)
    {

    }
}
