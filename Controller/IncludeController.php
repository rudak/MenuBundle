<?php

namespace Rudak\MenuBundle\Controller;

use Rudak\MenuBundle\Util\MenuHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IncludeController extends Controller
{

	private $htmlItems;
	private $wrapper;
	private $config;

	public function getHtmlMenuAction($wrapper = false)
	{
		$this->wrapper                     = $wrapper;
		$config                            = $this->container->getParameter('rudak.menu.config');
		$items                             = $config['items'];
		$this->config['current_classname'] = $config['current_classname'];
		$this->config['other_classname']   = $config['other_classname'];

		foreach ($items as $item) {
			$this->addHtmlItem($item);
		}

		$html     = $this->getHtml();
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
			$this->getItemClass($item),
			$this->getHref($item),
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

	private function getItemClass($item)
	{
		return ($item['route'] == $this->get('session')->get(MenuHandler::MENU_ITEM))
			? $this->config['current_classname']
			: $this->config['other_classname'];
	}

	private function getHref($item)
	{
		return $this->generateUrl($item['route']);
	}

}
