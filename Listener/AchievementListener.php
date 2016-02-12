<?php

namespace Avoo\AchievementBundle\Listener;
use AppBundle\Entity\UserAchievement;
use Avoo\AchievementBundle\Model\UserAchievementInterface;
use Avoo\AchievementBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class AchievementListener
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
abstract class AchievementListener implements AchievementListenerInterface
{
    /**
     * @var string $category
     */
    protected $category;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var boolean $value
     */
    protected $value;

    /**
     * @var bool $isComplete
     */
    protected $isComplete = false;

    /**
     * @var UserInterface|null $user
     */
    protected $user;

    /**
     * @var UserAchievementInterface $userAchievement
     */
    protected $userAchievement;

    /**
     * Construct
     *
     * @param string                $category
     * @param string                $name
     * @param boolean               $value
     * @param TokenStorageInterface $security
     */
    public function __construct($category, $name, $value, TokenStorageInterface $security)
    {
        $this->category = $category;
        $this->name = $name;
        $this->value = $value;

        $token = $security->getToken();
        if (null !== $token && is_object($user = $token->getUser())) {
            $this->user = $user;
        }

        $this->userAchievement = new UserAchievement();
    }

    /**
     * {@inheritdoc}
     */
    public function getAchievementProgress()
    {
        return $this->userAchievement->getProgress();
    }

    public function isComplete()
    {
        return $this->isComplete;
    }
}
