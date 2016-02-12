<?php

namespace Avoo\AchievementBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RegisterAchievementsCheckerPass
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class RegisterAchievementsCheckerPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $checkers = array();
        foreach ($container->findTaggedServiceIds('avoo_achievement.achievement') as $id => $attributes) {
            $checkers[$attributes[0]['type']] = $id;
        }

        $container->setParameter('avoo_achievement.achievements', $checkers);
    }
}
