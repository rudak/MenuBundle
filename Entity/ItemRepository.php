<?php

namespace Rudak\MenuBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ItemRepository extends EntityRepository
{
	public function getItemsByRank()
	{
		$qb = $this->createQueryBuilder('i')
				   ->addSelect('p')
				   ->leftJoin('i.page', 'p')
				   ->where('i.active = 1')
				   ->orderBy('i.rank', 'ASC')
				   ->getQuery();
		return $qb->execute();
	}

	public function findallByRank(){
		$qb = $this->createQueryBuilder('i')
				   ->addSelect('p')
				   ->leftJoin('i.page', 'p')
				   ->orderBy('i.rank', 'ASC')
				   ->getQuery();
		return $qb->execute();
	}
}
