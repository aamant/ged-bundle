<?php

namespace Aamant\GedBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('aamant_ged');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->children()
                ->arrayNode('default_sort')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('attribute')->defaultValue('title')->end()
                        ->scalarNode('order')->defaultValue('asc')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
