<?php
/**
 * Created by PhpStorm.
 * User: rudak
 * Date: 23/05/2015
 * Time: 19:42
 */

namespace Rudak\MenuBundle\Elements;


use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;

class Item
{

	private $title;
	private $route;
	private $index;
	private $currentClassname;
	private $otherClassname;

	private $hierarchy;
	private $session;

	function __construct($config_item, Session $session, Router $router, $config)
	{
		$this->title            = $config_item['title'];
		$this->route            = $config_item['route'];
		$this->index            = $config_item['index'];
		$this->currentClassname = $config['current_classname'];
		$this->otherClassname   = $config['other_classname'];
		$this->session          = $session;
		$this->router           = $router;
		$this->hierarchy        = false;
	}

	/**
	 * Renvoie le HTML de l'element LI et du lien
	 *
	 * @return string
	 */
	public function getHtml()
	{
		return sprintf($this->getPattern(), $this->getClass(), $this->getUrl(), $this->title, $this->index);
	}

	/**
	 * Renvoie le pattern du LI et du lien
	 *
	 * @return string
	 */
	private function getPattern()
	{
		return "<li class='%s'>\n<a href='%s' title='%s'>%s</a>\n</li>\n";
	}

	/**
	 * Défini et renvoie la classe a donner au LI
	 * Si la route de l'élément est configurée comme étant parente d'une autre route (config.yml),
	 * on va chercher a voir si la route en session (la page visitée) se trouve dans les enfants.
	 * Si c'est le cas, la classe active sera retournée, sinon inactive.
	 * Si il n'y a pas de hierarchie détectée, il y a juste une comparaison sur la route en session
	 * et la route en cours.
	 *
	 * @return mixed
	 */
	private function getClass()
	{
		$session_entry = $this->session->get(Menu::MENU_ITEM);
		if ($this->hierarchy) {
			if (in_array($session_entry, $this->hierarchy) || $this->route == $session_entry) {
				return $this->currentClassname;
			} else {
				return $this->otherClassname;
			}
		} else {
			return ($this->route == $session_entry) ? $this->currentClassname : $this->otherClassname;
		}
	}

	/**
	 * Renvoie l'url correspondant a la route si elle existe, sinon renvoie #
	 *
	 * @return string
	 */
	private function getUrl()
	{
		return ($this->routeExists($this->route)) ? $this->router->generate($this->route) : '#route_error';
	}

	/**
	 * On vérifie la configuration de la hierarchie, si cette route a des enfants, on les places tous dans
	 * le tableau hierarchy, qui sera parsé au moment de la definition de la classe.
	 *
	 * @param $hierarchy_config
	 */
	public function checkHierarchy($hierarchy_config)
	{
		foreach ($hierarchy_config as $parent_key => $childs) {
			if ($this->route == $parent_key) {
				foreach ($childs as $child) {
					$this->hierarchy[] = $child;
				}
			}
		}
	}

	/**
	 * Vérifie si la route existe et renvoie true si c'est le cas, sinon false.
	 *
	 * @param $routeName
	 * @return bool
	 */
	private function routeExists($routeName)
	{
		$router = $this->router;
		return (null === $router->getRouteCollection()->get($routeName)) ? false : true;
	}

}