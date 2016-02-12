<?php

namespace Avoo\AchievementBundle\Repository;

use Avoo\AchievementBundle\Model\UserInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class UserAchievementRepository
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class UserAchievementRepository extends EntityRepository
{
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
