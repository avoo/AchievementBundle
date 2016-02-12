<?php

namespace Avoo\AchievementBundle\Listener;

/**
 * Class Test
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class Test extends AchievementListener
{
    /**
     * {@inheritdoc}
     */
    public function progress($value, $object = null)
    {
        return $this;
    }

    public function verify($object = null)
    {
    }
}
