<?php

namespace Avoo\AchievementBundle\Repository;

use Avoo\AchievementBundle\Model\AchievementInterface;
use Avoo\AchievementBundle\Model\CategoryInterface;
use Avoo\AchievementBundle\Model\UserInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class AchievementRepository
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
class AchievementRepository extends EntityRepository
{
    /**
     * Get achievements list by category
     *
     * @param CategoryInterface|null $category
     * @param boolean                $enabled
     *
     * @return AchievementInterface[]
     */
    public function getAchievements(CategoryInterface $category = null, $enabled = true)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.enabled = :enabled')
            ->setParameter('enabled', $enabled);

        if (!is_null($category)) {
            $query->andWhere('a.category = :category')
                ->setParameter('category', $category);
        }

        $achievements = $query->getQuery()->getResult();

        return $achievements;
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

    }
}
