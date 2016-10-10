<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Safe\CatBundle\Entity\ThetaEstimationMethodType;
/**
 * ItemBank
 *
 * @ORM\Table(name="cat_item_bank")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\ItemBankRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class ItemBank
{

    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, nullable=false)
     */
    private $code;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\Item", mappedBy="itemBank", cascade={"remove"}) 
     */
    private $items;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\Ability", mappedBy="itemBank")
     */
    private $abilities;

    
    /**
     * @var string
     *
     * @ORM\Column(name="item_type", type="string", length=50, nullable=false)
     */
    private $itemType;

    /**
     * @var array
     *
     * @ORM\Column(name="item_range", type="array")
     */
    private $itemRange;
    
    /**
     * @var string
     *
     * @ORM\Column(name="theta_est_method", type="string", length=20, nullable=false)
     */
    private $thetaEstimationMethod;
    
    /**
     * @var float
     *
     * @ORM\Column(name="discret_increment", type="float", nullable=false)
     */
    private $discretIncrement;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    public function __construct($itemType = ItemType::RASH, $itemRange = array(-3,3), $thetaEstimationMethod = ThetaEstimationMethodType::THETA_NEWTON_RAPHSON, $discretIncrement = 0.25)
    {
        $this->items = new ArrayCollection();
        $this->abilities = new ArrayCollection();
        $this->itemType = $itemType;
        $this->itemRange = $itemRange;
        $this->thetaEstimationMethod = $thetaEstimationMethod;
        $this->discretIncrement = $discretIncrement;
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
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return ItemBank
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set items
     *
     * @param \stdClass $items
     *
     * @return ItemBank
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return \stdClass
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set itemType
     *
     * @param string $itemType
     *
     * @return ItemBank
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;

        return $this;
    }

    /**
     * Get itemType
     *
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * Set abilities
     *
     * @param \stdClass $abilities
     *
     * @return ItemBank
     */
    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;

        return $this;
    }

    /**
     * Get abilities
     *
     * @return \stdClass
     */
    public function getAbilities()
    {
        return $this->abilities;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ItemBank
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return ItemBank
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    function getItemRange() {
        return $this->itemRange;
    }

    function getThetaEstimationMethod() {
        return $this->thetaEstimationMethod;
    }

    function setItemRange($itemRange) {
        $this->itemRange = $itemRange;
    }

    function setThetaEstimationMethod($thetaEstimationMethod) {
        $this->thetaEstimationMethod = $thetaEstimationMethod;
    }
    
    function getDiscretIncrement() {
        return $this->discretIncrement;
    }

    function setDiscretIncrement($discretIncrement) {
        $this->discretIncrement = $discretIncrement;
    }




}

