<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Examinee
 *
 * @ORM\Table(name="cat_examinee")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\ExamineeRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class Examinee {
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, nullable=FALSE)
     */    
    private $code;

    /**
     * 
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\Ability", mappedBy="examinee", cascade={"remove"})     
     */
    private $abilities;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\ItemResult", mappedBy="examinee", cascade={"remove"})     
     */
    private $itemsResults;
    
    /**
    * @var \DateTime
    *
    * @ORM\Column(name="created", type="datetime", nullable=false)
    * @Expose
    */
    private $created;
    
    public function __construct()
    {
        $this->abilities = new ArrayCollection();
        $this->itemsResults = new ArrayCollection();
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimeStamp() {        
        if ($this->getCreated() == NULL) {
            $this->setCreated(new \DateTime());
        }
    }
    
    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getAbilities() {
        return $this->abilities;
    }

    function getCreated() {
        return $this->created;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setAbilities($abilities) {
        $this->abilities = $abilities;
    }

    function setCreated(\DateTime $created) {
        $this->created = $created;
    }

    function getItemsResults() {
        return $this->itemsResults;
    }

    function setItemsResults($itemsResults) {
        $this->itemsResults = $itemsResults;
    }    
}
