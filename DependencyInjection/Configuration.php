<?php

namespace FDevs\Bridge\Locale\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const CUSTOM_DRIVER = 'custom';

    /**
     * @var array
     */
    protected $supportedDrivers = [self::CUSTOM_DRIVER, 'mongodb'];

    /**
     * @var NodeBuilder
     */
    private $root;

    /**
     * @var TreeBuilder
     */
    private $treeBuilder;

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $rootNode = $this->getRootNode();

        $rootNode
            ->children()
                ->append($this->dbDriver())
                ->arrayNode('allowed_locales')
                    ->requiresAtLeastOneElement()
                    ->defaultValue(['en'])
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('translator_extensions')
                    ->defaultValue([])->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $this->treeBuilder;
    }

    /**
     * get root node.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition|TreeBuilder
     */
    protected function getRootNode()
    {
        if (!$this->root) {
            $this->treeBuilder = new TreeBuilder();
            $this->root = $this->treeBuilder->root('f_devs_locale');
        }

        return $this->root;
    }

    /**
     * @param string $name
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    protected function getNode($name)
    {
        $treeBuilder = new TreeBuilder();

        return $treeBuilder->root($name);
    }

    /**
     * db driver.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    protected function dbDriver()
    {
        $rootNode = $this->getNode('db');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')
                    ->defaultValue(self::CUSTOM_DRIVER)
                    ->validate()
                        ->ifNotInArray($this->supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($this->supportedDrivers))
                    ->end()
                ->end()
                ->scalarNode('manager_name')->defaultNull()->end()
            ->end()
        ;

        return $rootNode;
    }
}
