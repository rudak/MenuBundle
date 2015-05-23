<?php
namespace Rudak\MenuBundle\Util;


use Symfony\Component\HttpFoundation\Session\Session;

class MenuHandler
{

	const MENU_ITEM = 'menu_item';

	private $session;
	private $item;

	function __construct(Session $session)
	{
		$this->session = $session;
	}


	public function setItem($item = null)
	{
		if (null === $item) {
			return false;
		}
		$this->item = $item;
		$this->session->set(self::MENU_ITEM, $this->item);
		return true;
	}

	public function getItem()
	{
		return $this->session->get(self::MENU_ITEM);
	}


}