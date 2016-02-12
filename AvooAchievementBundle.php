<?php

namespace Avoo\AchievementBundle;

use Avoo\AchievementBundle\DependencyInjection\Compiler\RegisterAchievementsCheckerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AvooAchievementBundle
 *
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class AvooAchievementBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterAchievementsCheckerPass());
    }
}
