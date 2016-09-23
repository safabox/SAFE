<?php
namespace Safe\CatBundle\Entity;

use Safe\CatBundle\Entity\ItemType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Item
 *
 * @ORM\Table(name="cat_item")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\ItemRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class Item {
    
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
     * @var float
     * @ORM\Column(name="b", type="float")  
     * dificultad -3 < b < 3
     */
    private $b;
        
    /**
     * @var float
     * @ORM\Column(name="a", type="float")  
     * discriminador a > 0
     */
    private $a;
    
    /**
     * @var float
     * @ORM\Column(name="c", type="float")  
     * acierto 0 < c < 1
     */
    private $c;
    
    /**
     * @var float
     * @ORM\Column(name="d", type="float")  
     */
    private $d;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\ItemBank", inversedBy="items")
     * @ORM\JoinColumn(name="item_bank_id", referencedColumnName="id", nullable=FALSE)    
     */
    private $itemBank;
    
    /**
     *      
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\ItemResult", mappedBy="item")     
     */    
    private $itemsResults; //Los resultados son propios del examinado, no se borran en cascada
    
     /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, nullable=FALSE)
     */    
    private $code;
    
   /**
    * @var \DateTime
    *
    * @ORM\Column(name="created", type="datetime", nullable=false)
    * @Expose
    */
    private $created;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     * @Expose
     */
    private $updated;
    
    //https://en.wikipedia.org/wiki/Item_response_theory#IRT_models
    public function __construct()
    {
        $this->itemsResults = new ArrayCollection();
        $this->a = 1;
        $this->b = 0;
        $this->c = 0;
        $this->d = 1.7;
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimeStamp() {
        $this->setUpdated(new \DateTime());
        if ($this->getCreated() == NULL) {
            $this->setCreated(new \DateTime());
        }
    }

    function getId() {
        return $this->id;
    }

    function getItemBank() {
        return $this->itemBank;
    }

    function getB() {
        return $this->b;
    }

    function getA() {
        return $this->a;
    }

    function getC() {
        return $this->c;
    }

    function getD() {
        return $this->d;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setItemBank($itemBank) {
        $this->itemBank = $itemBank;
    }

    function setB($b) {
        $this->b = $b;
    }

    function setA($a) {
        $this->a = $a;
    }

    function setC($c) {
        $this->c = $c;
    }

    function setD($d) {
        $this->d = $d;
    }

    function getCreated() {
        return $this->created;
    }

    function setCreated(\DateTime $created) {
        $this->created = $created;
    }

    function getItemsResults() {
        return $this->itemsResults;
    }

    function getUpdated() {
        return $this->updated;
    }

    function setItemsResults($itemsResults) {
        $this->itemsResults = $itemsResults;
    }

    function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
    }

    function getItemType() {
        return $this->itemBank->getItemType();
    }

    function getCode() {
        return $this->code;
    }

    function setCode($code) {
        $this->code = $code;
    }



    
}
