<?php

namespace Avoo\AchievementBundle\Entity;
use Avoo\AchievementBundle\Model\CategoryInterface;

/**
 * Class Category
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class Category implements CategoryInterface
{
    /**
     * @var string $name
     */
    protected $name;

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
}
