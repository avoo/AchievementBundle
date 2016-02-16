<?php

namespace Avoo\AchievementBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Parser;

/**
 * Class AvooAchievementExtension
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
class AvooAchievementExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setAlias('avoo_achievement', $config['service']['class']);
        $container->setParameter('avoo_achievement.repository', $config['user_achievement_class']);

        foreach ($config['achievements'] as $category => $achievements) {
            foreach ($achievements as $type => $achievement) {
                $definition = new Definition();
                $definition->setClass($achievement['class']);
                $definition->setArguments(array(
                    'id' => $category . '.' . $type,
                    'category' => $category,
                    'name' => $achievement['name'],
                    'value' => $achievement['value'],
                    'manager' => new Reference('doctrine.orm.default_entity_manager')
                ));

                $definition->setMethodCalls(array(
                    array('setUser', array(new Reference('security.token_storage'))),
                    array('setRepository', array($config['user_achievement_class'])),
                ));

                $definition->addTag('avoo_achievement.achievement', array('type' => $category . '.' . $type));

                $container->setDefinition(sprintf('avoo_achievement.achievement.%s.%s', $category, $type), $definition);
            }
        }
    }
}
