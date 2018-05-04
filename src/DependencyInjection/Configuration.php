<?php
declare(strict_types = 1);

namespace Enm\Bundle\ShopwareSdk\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     * @throws \RuntimeException
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        
        $root = $treeBuilder->root('enm_shopware_sdk')->children();
        
        $root->scalarNode('base_url')->isRequired()->cannotBeEmpty();
        
        $root->scalarNode('username')->isRequired()->cannotBeEmpty();
        
        $root->scalarNode('api_key')->isRequired()->cannotBeEmpty();
        
        return $treeBuilder;
    }
}
