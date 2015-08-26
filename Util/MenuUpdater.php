<?php
/**
 * Created by PhpStorm.
 * User: rudak
 * Date: 23/05/2015
 * Time: 11:27
 */

namespace Rudak\MenuBundle\Util;

use Symfony\Component\HttpFoundation\Session\Session;

class MenuUpdater
{

	private $session;

	function __construct(Session $session)
	{
		$this->session = $session;
	}

	public function update($routeName)
	{
		$MenuHandler = new MenuHandler($this->session);
		$MenuHandler->setItem($routeName);
	}


}