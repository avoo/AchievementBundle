<?php

namespace Avoo\AchievementBundle\Listener;

use Avoo\AchievementBundle\Model\UserAchievementInterface;
use Avoo\AchievementBundle\Model\UserInterface;
use Avoo\AchievementBundle\Repository\UserAchievementRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class AchievementListener
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
abstract class AchievementListener implements AchievementListenerInterface
{
    /**
     * @var AchievementOptionsInterface $options
     */
    protected $options;

    /**
     * @var UserAchievementInterface $userAchievement
     */
    protected $userAchievement;

    /**
     * @var UserInterface|null $user
     */
    private $user;

    /**
     * @var UserAchievementRepository $repository
     */
    private $repository;

    /**
     * @var EntityManager $manager
     */
    private $manager;

    /**
     * @var bool $isComplete
     */
    private $isComplete = false;

    /**
     * Construct
     *
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(AchievementOptionsInterface $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(TokenStorageInterface $security)
    {
        $token = $security->getToken();
        if (null !== $token && is_object($user = $token->getUser())) {
            $this->user = $user;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository($repository)
    {
        if (!is_null($this->user)) {
            $this->repository = $this->manager->getRepository($repository);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setUserAchievement(UserAchievementInterface $userAchievement)
    {
        $this->userAchievement = $userAchievement;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserAchievement()
    {
        if (is_null($this->userAchievement)) {
            $className = $this->repository->getClassName();
            $this->userAchievement = new $className;
            $this->userAchievement->setAchievement($this->getOptions()->getId());
            $this->userAchievement->setUser($this->user);

            $userAchievement = $this->repository->getAchievement($this->getOptions()->getId(), $this->user);

            if (!is_null($userAchievement)) {
                $this->userAchievement = $userAchievement;
                $this->isComplete = !is_null($userAchievement->getCompleteAt()) ? true : false;
            }
        }

        return $this->userAchievement;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid($object = null)
    {
        throw new \RuntimeException(sprintf('You must implement the function "%s" in your achievement listener.', __FUNCTION__));
    }

    /**
     * {@inheritdoc}
     */
    public function progress($value)
    {
        if (is_null($this->userAchievement) || $this->isComplete()) {
            return false;
        }

        if (($progress = $this->userAchievement->getProgress() + $value) >= $this->getOptions()->getValue()) {
            $this->userAchievement->setProgress($this->getOptions()->getValue());
            $this->userAchievement->setCompleteAt(new \DateTime());
            $this->isComplete = true;
        } else {
            $this->userAchievement->setProgress($progress);
        }

        $this->manager->persist($this->userAchievement);
        $this->manager->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isComplete()
    {
        return $this->isComplete;
    }
}
