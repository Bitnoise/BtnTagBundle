<?php

namespace Btn\TagBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('btn_tag');

        $rootNode
            ->children()
                ->arrayNode('tag')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->cannotBeEmpty()->defaultValue('Btn\\TagBundle\\Entity\\Tag')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
