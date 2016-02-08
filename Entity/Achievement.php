<?php

namespace Avoo\AchievementBundle\Entity;

use Avoo\AchievementBundle\Model\AchievementInterface;
use Avoo\AchievementBundle\Model\CategoryInterface;

/**
 * Class Achievement
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class Achievement implements AchievementInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var CategoryInterface $category
     */
    protected $category;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $event
     */
    protected $event;

    /**
     * @var string $method
     */
    protected $method;

    /**
     * @var \DateTime $completeAt
     */
    protected $completeAt;

    /**
     * Get getId
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setEvent($eventName)
    {
        $this->event = $eventName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * {@inheritdoc}
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }
}
