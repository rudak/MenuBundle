<?php
/**
 * Created by PhpStorm.
 * User: rudak
 * Date: 23/08/2015
 * Time: 00:58
 */

namespace Rudak\MenuBundle\Command;

use Rudak\MenuBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateCommand extends ContainerAwareCommand
{

	private $em;

	protected function configure()
	{
		$this->setName('rudakMenu:populate')
			 ->setDescription('Va chercher les pages actives du cms et les intègre dans le menu dynamique');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if ($this->bundleExists('RudakCmsBundle')) {
			$output->writeln('RudakCmsBundle exist');
			$Pages     = $this->getPages();
			$ItemsInDB = $this->getItems();
			$Items     = array();
			$nb        = 0;
			$output->writeln(count($Pages) . ' pages in database');
			foreach ($Pages as $page) {
				if ($this->checkIfAlreadyRecorded($page, $ItemsInDB)) {
					$output->writeln('Page with Id #' . $page->getId() . ' is already in the database');
				} else {
					$Items[$nb] = new Item();
					$Items[$nb]->setRank(($nb + 1) * 10);
					$Items[$nb]->setPage($page);
					$Items[$nb]->setActive(false);
					$this->em->persist($Items[$nb]);
					$nb++;
					$output->writeln('Page with Id #' . $page->getId() . ' added to RudakMenu database');
				}
			}
			$this->em->flush();
		} else {
			$output->writeln('RudakCmsBundle does not exist');
		}
		$output->writeln('Operation terminee');
	}

	/**
	 * Renvoie l'entity manager
	 *
	 * @return mixed
	 */
	private function getEm()
	{
		if ($this->em == null) {
			$this->em = $this->getContainer()->get('doctrine')->getManager();
		}
		return $this->em;
	}

	private function bundleExists($bundle)
	{
		return array_key_exists(
			$bundle,
			$this->getContainer()->getParameter('kernel.bundles')
		);
	}

	private function getPages()
	{
		$em = $this->getEm();
		return $em->getRepository('RudakCmsBundle:Page')->findAll();
	}

	private function getItems()
	{
		$em = $this->getEm();
		return $em->getRepository('RudakMenuBundle:Item')->findAll();
	}

	private function checkIfAlreadyRecorded($page, $itemsList)
	{
		foreach ($itemsList as $item) {
			if ($page->getId() == $item->getPage()->getId()) {
				return true;
			}
		}
		return false;
	}
}