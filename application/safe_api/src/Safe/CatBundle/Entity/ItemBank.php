<?php
namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Safe\CatBundle\Entity\Item;
use Safe\CatBundle\Entity\ItemType;

/**
 * ItemBank
 *
 * @ORM\Table(name="cat_item_bank")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\ItemBankRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class ItemBank {
    
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
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\Item", mappedBy="itemBank", cascade={"remove"}) 
     */
    private $items;
    
    /**
     * @var string
     *
     * @ORM\Column(name="item_type", type="string", length=50)
     */    
    private $itemType;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\Ability", mappedBy="itemBank")     
     */
    private $abilities;
    
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
    

    public function __construct($code, $itemType = ItemType::RASH)
    {
        $this->code = $code;
        $this->items = new ArrayCollection();
        $this->abilities = new ArrayCollection();
        $this->itemType = $itemType;
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

    function getItemType() {
        return $this->itemType;
    }

    function getItems() {
        return $this->items;
    }

    function setItemType($itemType) {
        $this->itemType = $itemType;
    }

    function setItems($items) {
        $this->items = $items;
    }
    
    function getId() {
        return $this->id;
    }

    function getCreated() {
        return $this->created;
    }

    function getUpdated() {
        return $this->updated;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCreated(\DateTime $created) {
        $this->created = $created;
    }

    function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
    }

    function getCode() {
        return $this->code;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function getAbilities() {
        return $this->abilities;
    }

    function setAbilities($abilities) {
        $this->abilities = $abilities;
    }

}
