<?php

namespace Avoo\AchievementBundle\Listener;

/**
 * Class AchievementOptions
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class AchievementOptions implements AchievementOptionsInterface
{
    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var string $category
     */
    protected $category;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var float $value
     */
    protected $value;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $image
     */
    protected $image;

    /**
     * Construct
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->id = $options['id'];
        $this->category = $options['category'];
        $this->name = $options['name'];
        $this->value = $options['value'];
        $this->description = $options['description'];
        $this->image = $options['image'];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->image;
    }
}
