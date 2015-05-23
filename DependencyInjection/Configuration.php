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
		#TODO : ajouter nom de classe facultatif à rajouter au LI actif ('active' par défaut)
		#TODO : ajouter identifiant de session obligatoire (pas forcément unique), correspondant a la page vue, pour regrouper les items (nom de route par défaut pour l'instant)
		$rootNode->children()
				 	->arrayNode('items')
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
