<?php

namespace Rudak\MenuBundle\Controller;

use Rudak\MenuBundle\Util\MenuHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IncludeController extends Controller
{

	private $htmlItems;
	private $wrapper;


	public function getHtmlMenuAction($wrapper = false)
	{
		$this->wrapper = $wrapper;
		$config        = $this->container->getParameter('rudak.menu.config');
		$items         = $config['items'];

		foreach ($items as $item) {
			$this->addHtmlItem($item);
		}

		$html = $this->getHtml();


		$response = new Response($html);

		return $response;
	}

	private function getHtml()
	{
		if ($this->wrapper) {
			return sprintf($this->getMenuWrapper(), $this->htmlItems);
		} else {
			return $this->htmlItems;
		}
	}

	private function addHtmlItem($item)
	{
		$this->htmlItems .= sprintf(
			$this->getLineTemplate(),
			$this->getItemClass($item['route']),
			$this->getHref($item['route']),
			$item['title'],
			$item['index']
		);
	}

	private function getMenuWrapper()
	{
		return "<ul id='main_menu'>\n%s</ul>\n";
	}

	private function getLineTemplate()
	{
		return "<li class='%s'>\n<a href='%s' title='%s'>%s</a>\n</li>\n";
	}

	private function getItemClass($route)
	{
		$session_route = $this->get('session')->get(MenuHandler::MENU_ITEM);
		if ($route == $session_route) {
			return 'active';
		} else {
			return 'inactive';
		}
	}

	private function getHref($route)
	{
		return $this->generateUrl($route);
	}

}
