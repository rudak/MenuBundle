<?php
/**
 * Created by PhpStorm.
 * User: rudak
 * Date: 21/08/2015
 * Time: 12:25
 */

namespace Rudak\MenuBundle\Model;

use Rudak\CmsBundle\Entity\Page;
use Rudak\MenuBundle\Elements\Menu;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

class ObjectsToHtml
{

	private $items;
	private $html;
	private $Router;
	private $Session;

	public function __construct(array $items, Router $Router, Session $Session)
	{
		$this->items   = $items;
		$this->Router  = $Router;
		$this->Session = $Session;
	}

	public function getHtml()
	{
		foreach ($this->items as $item) {
			$this->html .= sprintf($this->getPattern(),
				$this->getElementClass($item->getPage()),
				$this->getUrl($item->getPage()),
				$item->getPage()->getName(),
				$item->getPage()->getName());
		}
		return $this->html;
	}

	private function getPattern()
	{
		return "<li class='%s'>\n<a href='%s' title='%s'>\n%s\n</a>\n</li>\n";
	}

	private function getUrl(Page $Page)
	{
		return $this->Router->generate('rudak_cms_page_read', array(
			'id'   => $Page->getId(),
			'name' => $Page->getName()
		));
	}

	private function getElementClass(Page $page)
	{
		if ($this->Session->has(Menu::MENU_PAGE_DYN)) {
			if ($this->Session->get(Menu::MENU_PAGE_DYN) == $page->getId()) {
				$this->Session->remove(Menu::MENU_PAGE_DYN);
				return 'active';
			} else {
				return 'inactive';
			}
		} else {
			return 'inactive';
		}
	}
}