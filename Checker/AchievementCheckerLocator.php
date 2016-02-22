<?php

namespace Avoo\AchievementBundle\Checker;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AchievementCheckerLocator
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class AchievementCheckerLocator implements AchievementCheckerLocatorInterface
{
    use ContainerAwareTrait;

    /**
     * @var array $checkers
     */
    private $checkers;

    /**
     * Construct
     *
     * @param array $checkers
     */
    public function __construct(array $checkers)
    {
        $this->checkers = $checkers;
    }

    /**
     * Get checkers list
     *
     * @return array $checkers
     */
    public function getCheckers()
    {
        return $this->checkers;
    }

    /**
     * {@inheritdoc}
     */
    public function has($type)
    {
        if (!isset($this->checkers[$type])) {
            return false;
        }

        return $this->container->has($this->checkers[$type]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($type)
    {
        if (!$this->has($type)) {
            throw new NotFoundHttpException(sprintf('The achievement key "%s" does not exist.', $type));
        }

        return $this->container->get($this->checkers[$type]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTypes($category = null)
    {
        $excludes = array();
        if (!is_null($category)) {
            foreach (array_keys($this->checkers) as $checker) {
                $pos = stripos($checker, $category . '.');
                if(false !== $pos && $pos == 0) {
                    continue;
                }

                $excludes[] = $checker;
            }
        }

        return  array_diff(array_keys($this->checkers), $excludes);
    }
}
