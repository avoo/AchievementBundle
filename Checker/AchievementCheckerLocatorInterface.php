<?php

namespace Avoo\AchievementBundle\Checker;

use Avoo\AchievementBundle\Listener\AchievementListenerInterface;


/**
 * Class AchievementCheckerLocatorInterface
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
interface AchievementCheckerLocatorInterface
{
    /**
     * Get Known checker types
     *
     * @return string[]
     */
    public function getTypes();

    /**
     * Is template checker of type $type known?
     *
     * @param string $type
     *
     * @return Boolean
     */
    public function has($type);
    /**
     * Get requested template Checker
     *
     * @param string $type
     *
     * @return AchievementListenerInterface
     */
    public function get($type);
}
