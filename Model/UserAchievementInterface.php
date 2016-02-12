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
     * Set achievement key
     *
     * @param string $achievement
     *
     * @return $this
     */
    public function setAchievement($achievement);

    /**
     * Get achievement key
     *
     * @return string
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
