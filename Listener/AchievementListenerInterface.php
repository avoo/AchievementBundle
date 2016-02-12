<?php

namespace Avoo\AchievementBundle\Listener;

/**
 * Class AchievementListenerInterface
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
interface AchievementListenerInterface
{
    /**
     * Execute progress achievement process
     *
     * @param float $value
     * @param mixed $object
     *
     * @return $this
     */
    public function progress($value, $object = null);

    /**
     * Return current progress achievement
     *
     * @return float
     */
    public function getAchievementProgress();

    /**
     * Return if current achievement is complete
     *
     * @return boolean
     */
    public function isComplete();
}
