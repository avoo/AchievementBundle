<?php

namespace Avoo\AchievementBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('avoo_achievement');

        $this->addServicesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds 'services' section.
     *
     * @param ArrayNodeDefinition $node
     */
    public function addServicesSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('avoo_achievement.achievement.default')->end()
                    ->end()
                ->end()
            ->end();
    }
}
