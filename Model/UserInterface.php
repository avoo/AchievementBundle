<?php

namespace Avoo\AchievementBundle\Model;

/**
 * Class UserInterface
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
interface UserInterface
{
    /**
     * Get achievements
     *
     * @return AchievementInterface[]
     */
    public function getAchievements();
}
