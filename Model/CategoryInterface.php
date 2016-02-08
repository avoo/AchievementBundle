<?php

namespace Avoo\AchievementBundle\Model;

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
}
