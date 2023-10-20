<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('answear_fan_courier');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('clientId')->isRequired()->cannotBeEmpty()->end()
            ?->scalarNode('username')->isRequired()->cannotBeEmpty()->end()
            ?->scalarNode('password')->isRequired()->cannotBeEmpty()->end()
            ?->scalarNode('apiUrl')->isRequired()->cannotBeEmpty()->end()
            ?->scalarNode('logger')->defaultNull()->end()
            ?->end();

        return $treeBuilder;
    }
}
