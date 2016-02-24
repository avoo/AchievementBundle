<?php

namespace Avoo\AchievementBundle\Entity;

use Avoo\AchievementBundle\Model\UserAchievementInterface;
use Avoo\AchievementBundle\Model\UserInterface;

/**
 * Class UserAchievement
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
abstract class UserAchievement implements UserAchievementInterface
{
    /**
     * Get id
     *
     * @var integer
     */
    protected $id;

    /**
     * @var string $achievement
     */
    protected $achievement;

    /**
     * @var UserInterface $user
     */
    protected $user;

    /**
     * @var float|integer $progress
     */
    protected $progress;

    /**
     * @var \DateTime $completeAt
     */
    protected $completeAt;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->progress = 0;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * {@inheritdoc}
     */
    public function setAchievement($achievement)
    {
        $this->achievement = $achievement;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAchievement()
    {
        return $this->achievement;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompleteAt(\DateTime $completeAt)
    {
        $this->completeAt = $completeAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompleteAt()
    {
        return $this->completeAt;
    }


}
