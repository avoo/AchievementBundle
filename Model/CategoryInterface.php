<?php

namespace Avoo\AchievementBundle\Model;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class CategoryInterface
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
interface CategoryInterface
{
    /**
     * Set category name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * Get category name
     *
     * @return string
     */
    public function getName();

    /**
     * Get achievements associated with this category
     *
     * @return ArrayCollection[AchievementInterface]
     */
    public function getAchievements();

    /**
     * Does a achievement belongs to category?
     *
     * @param AchievementInterface $achievement
     *
     * @return Boolean
     */
    public function hasAchievement(AchievementInterface $achievement);

    /**
     * Is there any achievements in category?
     *
     * @return bool
     */
    public function hasAchievements();

    /**
     * Add a achievement to category
     *
     * @param AchievementInterface $achievement
     *
     * @return $this
     */
    public function addAchievement(AchievementInterface $achievement);

    /**
     * Remove achievement from category
     *
     * @param AchievementInterface $achievement
     *
     * @return $this
     */
    public function removeAchievement(AchievementInterface $achievement);
}
