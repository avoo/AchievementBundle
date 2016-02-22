<?php

namespace Avoo\AchievementBundle\Listener;

use Avoo\AchievementBundle\Model\UserAchievementInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class AchievementListenerInterface
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
interface AchievementListenerInterface
{
    /**
     * Set options
     *
     * @param AchievementOptionsInterface $options
     */
    public function setOptions(AchievementOptionsInterface $options);

    /**
     * Get achievement options
     *
     * @return AchievementOptionsInterface
     */
    public function getOptions();

    /**
     * Set user
     *
     * @param TokenStorageInterface $security
     */
    public function setUser(TokenStorageInterface $security);

    /**
     * Set repository
     *
     * @param string $repository
     */
    public function setRepository($repository);

    /**
     * Return current user achievement
     *
     * @return UserAchievementInterface
     */
    public function getUserAchievement();

    /**
     * check achievement validation progress
     *
     * @param mixed|null $object
     *
     * @return boolean
     */
    public function isValid($object = null);

    /**
     * Execute progress achievement process
     *
     * @param float $value
     *
     * @return $this
     */
    public function progress($value);

    /**
     * Return if current achievement is complete
     *
     * @return boolean
     */
    public function isComplete();
}
