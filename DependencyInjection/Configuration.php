<?php

namespace Rudak\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link
 * http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

	/**
	 * {@inheritdoc}
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode    = $treeBuilder->root('rudak_menu');

		$rootNode->children()
					->scalarNode('current_classname')
						->defaultValue('active')
						->treatNullLike('active')
					->end()
					->scalarNode('other_classname')
						->defaultValue('inactive')
						->treatNullLike('')
					->end()
				 	->arrayNode('items')
						->isRequired()
						->requiresAtLeastOneElement()
						->prototype('array')
							->children()
								->scalarNode('index')->end()
								->scalarNode('route')->end()
							 	->scalarNode('title')->end()
							->end()
						->end()
			  		->end()
				 ->end();

		return $treeBuilder;
	}
}
