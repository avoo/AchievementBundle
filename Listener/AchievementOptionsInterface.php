<?php

namespace Avoo\AchievementBundle\Listener;

/**
 * Class AchievementOptionsInterface
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
interface AchievementOptionsInterface
{
    /**
     * Get achievement id
     *
     * @return string
     */
    public function getId();

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get value
     *
     * @return float
     */
    public function getValue();

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get image
     *
     * @return string
     */
    public function getImage();
}
