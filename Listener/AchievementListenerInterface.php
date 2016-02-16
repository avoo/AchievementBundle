<?php

namespace Avoo\AchievementBundle\Listener;

use Avoo\AchievementBundle\Model\UserAchievementInterface;

/**
 * Class AchievementListenerInterface
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
interface AchievementListenerInterface
{
    /**
     * Return current user achievement
     *
     * @return UserAchievementInterface
     */
    public function getUserAchievement();

    /**
     * check achievement validation progress
     *
     * @param mixed|null $object
     *
     * @return boolean
     */
    public function isValid($object = null);

    /**
     * Execute progress achievement process
     *
     * @param float $value
     *
     * @return $this
     */
    public function progress($value);

    /**
     * Return if current achievement is complete
     *
     * @return boolean
     */
    public function isComplete();

    /**
     * Get achievement name
     *
     * @return string
     */
    public function getName();

    /**
     * Get category name
     *
     * @return string
     */
    public function getCategory();

    /**
     * Get value
     *
     * @return bool
     */
    public function getValue();
}
