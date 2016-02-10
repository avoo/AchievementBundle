<?php

namespace Avoo\AchievementBundle\Entity;
use Avoo\AchievementBundle\Model\AchievementInterface;
use Avoo\AchievementBundle\Model\CategoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Category
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class Category implements CategoryInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var ArrayCollection[AchievementInterface] $achievements
     */
    protected $achievements;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->achievements = new ArrayCollection();
    }

    /**
     * Get id
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
    public function getAchievements()
    {
        return $this->achievements;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAchievement(AchievementInterface $achievement)
    {
        return $this->achievements->contains($achievement);
    }

    /**
     * {@inheritdoc}
     */
    public function hasAchievements()
    {
        return !$this->achievements->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function addAchievement(AchievementInterface $achievement)
    {
        if (! $this->hasAchievement($achievement)) {
            $this->achievements->add($achievement);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAchievement(AchievementInterface $achievement)
    {
        if ($this->hasAchievement($achievement)) {
            $this->achievements->removeElement($achievement);
        }

        return $this;
    }
}
