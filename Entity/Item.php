<?php

namespace Rudak\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#TODO: ajouter une commande qui boucle sur les pages pour creer des items si le cmsBundle existe

/**
 * Item
 *
 * @ORM\Table(name="rudakMenu_item")
 * @ORM\Entity(repositoryClass="Rudak\MenuBundle\Entity\ItemRepository")
 */
class Item
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="smallint")
     */
    private $rank;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean",nullable=true)
     */
    private $active;

    /**
     * @ORM\OneToOne(targetEntity="Rudak\CmsBundle\Entity\Page")
     */
    private $page;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set rank
     *
     * @param integer $rank
     * @return Item
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Item
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set page
     *
     * @param \Rudak\CmsBundle\Entity\Page $page
     * @return Item
     */
    public function setPage(\Rudak\CmsBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Rudak\CmsBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }
}
