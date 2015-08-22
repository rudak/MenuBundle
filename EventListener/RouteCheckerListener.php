<?php
/**
 * Created by PhpStorm.
 * User: rudak
 * Date: 27/05/2015
 * Time: 18:58
 */

namespace Rudak\MenuBundle\EventListener;

use Rudak\MenuBundle\Elements\Menu;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class RouteCheckerListener
{

	public function onKernelRequest(GetResponseEvent $event)
	{
		if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
			return;
		}

		$request = $event->getRequest();
		$session = $request->getSession();
		$routeName = $request->get('_route');
		if ($routeName == 'rudak_cms_page_read') {
			$params = $request->attributes->get('_route_params');
			$session->set(Menu::MENU_PAGE_DYN, $params['id']);
		} else {
			$session->set(Menu::MENU_ITEM, $routeName);
		}
	}
}