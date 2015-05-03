<?php
/**
 * Created by PhpStorm.
 * User: konstantin.khotski
 * Date: 5/3/2015
 * Time: 12:14 PM
 */

namespace Azusdex\NexmoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nexmo');

        $rootNode->children()->scalarNode('api_key')->isRequired()->end();
        $rootNode->children()->scalarNode('api_secret')->isRequired()->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}