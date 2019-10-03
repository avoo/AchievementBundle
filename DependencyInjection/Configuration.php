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
        $treeBuilder = new TreeBuilder('avoo_achievement');
        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('avoo_achievement');
        }

        $this->addServicesSection($rootNode);
        $this->addAchievementsSection($rootNode);

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
                ->scalarNode('user_achievement_class')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->defaultValue('avoo_achievement.achievement.default')->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * Adds achievements section.
     *
     * @param ArrayNodeDefinition $node
     */
    public function addAchievementsSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('achievements')
                    ->useAttributeAsKey('category')
                    ->prototype('array')
                        ->useAttributeAsKey('achievement')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('value')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('description')->end()
                                ->scalarNode('image')->defaultValue('bundles/avooachievement/images/unknown.png')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
