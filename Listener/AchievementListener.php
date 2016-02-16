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
     * @param string        $id
     * @param string        $category
     * @param string        $name
     * @param boolean       $value
     * @param EntityManager $manager
     */
    public function __construct($id, $category, $name, $value, EntityManager $manager)
    {
        $this->id = $id;
        $this->category = $category;
        $this->name = $name;
        $this->value = $value;
        $this->manager = $manager;
    }


    /**
     * Set user
     *
     * @param TokenStorageInterface $security
     */
    public function setUser(TokenStorageInterface $security)
    {
        $token = $security->getToken();
        if (null !== $token && is_object($user = $token->getUser())) {
            $this->user = $user;
        }
    }

    /**
     * Set repository
     *
     * @param string $repository
     */
    public function setRepository($repository)
    {
        if (!is_null($this->user)) {
            $this->repository = $this->manager->getRepository($repository);
            $className = $this->repository->getClassName();
            $this->userAchievement = new $className;
            $this->userAchievement->setAchievement($this->id);
            $this->userAchievement->setUser($this->user);

            $userAchievement = $this->repository->getAchievement($this->id, $this->user);

            if (!is_null($userAchievement)) {
                $this->userAchievement = $userAchievement;
                $this->isComplete = !is_null($userAchievement->getCompleteAt()) ? true : false;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUserAchievement()
    {
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
     * Progress
     *
     * @param float $value
     *
     * @return boolean
     */
    public function progress($value)
    {
        if (is_null($this->userAchievement) || $this->isComplete()) {
            return false;
        }

        if (($progress = $this->userAchievement->getProgress() + $value) >= $this->value) {
            $this->userAchievement->setProgress($this->value);
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
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }
}
