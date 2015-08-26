<?php

namespace Rudak\MenuBundle\Controller;

use Rudak\MenuBundle\Elements\Hierarchy;
use Rudak\MenuBundle\Elements\Item;
use Rudak\MenuBundle\Elements\Menu;
use Rudak\MenuBundle\Model\ObjectsToHtml;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IncludeController extends Controller
{

	private $Menu;
	private $config;
	private $router;

	public function getHtmlMenuAction($wrapper = false)
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

		$response = new Response($this->Menu->getHtml());
		return $response;
	}

	public function getDatabaseMenuAction()
	{
		$em             = $this->getDoctrine()->getManager();
		$repo           = $em->getRepository('RudakMenuBundle:Item');
		$entities       = $repo->getItemsByRank();
		$EntitiesToHtml = new ObjectsToHtml($entities, $this->get("router"), $this->get('session'));
		$html           = $EntitiesToHtml->getHtml();

		return new Response($html);
	}


}
