<?php
/**
 * Created by PhpStorm.
 * User: rudak
 * Date: 23/05/2015
 * Time: 19:42
 */

namespace Rudak\MenuBundle\Elements;


class Menu
{

	const MENU_ITEM     = 'menu_item';
	const MENU_PAGE_DYN = 'CmsPageDynID';

	private $wrapper;
	private $id;
	private $class;
	public  $items;

	function __construct($wrapper, $id = null, $class = null)
	{
		$this->wrapper = $wrapper;
		$this->id      = $id;
		$this->class   = $class;
		$this->items   = array();
	}

	/**
	 * Ajoute une entrée dans le menu
	 *
	 * @param mixed $item
	 */
	public function addItem(Item $item)
	{
		$this->items[] = $item;
	}

	/**
	 * Renvoie le HTML a afficher (du menu complet)
	 */
	public function getHtml()
	{
		return sprintf($this->getWrapperPattern(), $this->getListHtml());
	}


	/**
	 * Renvoie le pattern du menu. (Un <UL> ou rien du tout)
	 *
	 * @return string
	 */
	private function getWrapperPattern()
	{
		return ($this->wrapper) ? "<ul id='%s' class='%s'>\n%s</ul>\n" : "%s";
	}

	/**
	 * crée et renvoie le HTML des elements LI
	 *
	 * @return string
	 */
	private function getListHtml()
	{
		$out = '';
		foreach ($this->items as $item) {
			$out .= $item->getHtml();
		}
		return $out;
	}

}