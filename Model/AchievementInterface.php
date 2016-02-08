<?php

namespace Avoo\AchievementBundle\Model;

/**
 * Class AchievementInterface
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
interface AchievementInterface
{
    /**
     * Set category
     *
     * @param CategoryInterface $category
     *
     * @return $this
     */
    public function setCategory(CategoryInterface $category);

    /**
     * Get category
     *
     * @return CategoryInterface
     */
    public function getCategory();

    /**
     * Set name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set event name
     *
     * @param string $eventName
     *
     * @return $this
     */
    public function setEvent($eventName);

    /**
     * Get event name
     *
     * @return string
     */
    public function getEvent();

    /**
     * Set method
     *
     * @param string $method
     *
     * @return $this
     */
    public function setMethod($method);

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod();
}
