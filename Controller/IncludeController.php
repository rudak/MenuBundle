<?php

namespace Rudak\MenuBundle\Controller;

use Rudak\MenuBundle\Elements\Hierarchy;
use Rudak\MenuBundle\Elements\Item;
use Rudak\MenuBundle\Elements\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IncludeController extends Controller
{

	private $Menu;
	private $config;
	private $router;

	public function getHtmlMenuAction($wrapper)
	{
		$session      = $this->get('session');
		$this->config = $this->container->getParameter('rudak.menu.config');
		$this->Menu   = new Menu($wrapper);
		$this->router = $this->get('router');

		foreach ($this->config['items'] as $config_item) {
			$Item = new Item($config_item, $session, $this->router, $this->config['configuration']);
			$Item->checkHierarchy($this->config['hierachy']);
			$this->Menu->addItem($Item);
		}
		//var_dump($this->Menu->items);

		$response = new Response($this->Menu->getHtml());
		return $response;
	}


}
