<?php

namespace Avoo\AchievementBundle\Model;

/**
 * Class UserAchievementInterface
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
interface UserAchievementInterface
{
    /**
     * Set achievement
     *
     * @param AchievementInterface $achievement
     *
     * @return $this
     */
    public function setAchievement(AchievementInterface $achievement);

    /**
     * Get achievement
     *
     * @return AchievementInterface
     */
    public function getAchievement();

    /**
     * Set user
     *
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user);

    /**
     * Get user
     *
     * @return UserInterface
     */
    public function getUser();

    /**
     * Set progress
     *
     * @param float $progress
     *
     * @return $this
     */
    public function setProgress($progress);

    /**
     * Get progress
     *
     * @return float
     */
    public function getProgress();

    /**
     * Set complete at
     *
     * @param \DateTime $completeAt
     *
     * @return $this
     */
    public function setCompleteAt(\DateTime $completeAt);

    /**
     * Get complete at
     *
     * @return \DateTime
     */
    public function getCompleteAt();
}
