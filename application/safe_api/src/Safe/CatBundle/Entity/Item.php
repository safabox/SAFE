<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Safe\CatBundle\Entity\ItemResult;

/**
 * Item
 *
 * @ORM\Table(name="cat_item")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\ItemRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class Item
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
     * @var float
     *
     * @ORM\Column(name="b", type="float", nullable=false)
     */
    private $b;

    /**
     * @var float
     *
     * @ORM\Column(name="a", type="float", nullable=false)
     */
    private $a;

    /**
     * @var float
     *
     * @ORM\Column(name="c", type="float", nullable=false)
     */
    private $c;

    /**
     * @var float
     *
     * @ORM\Column(name="d", type="float", nullable=false)
     */
    private $d;
    
    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\ItemBank", inversedBy="items")
     * @ORM\JoinColumn(name="item_bank_id", referencedColumnName="id", nullable=false)
     */
    private $itemBank;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\ItemResult", mappedBy="item", cascade={"persist"}) 
     */
    private $itemsResults;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, nullable=false)
     */
    private $code;

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


    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     *
     */
    private $enabled;
    
    //https://en.wikipedia.org/wiki/Item_response_theory#IRT_models
    public function __construct($b=0, $a=1, $c=0, $d=1)
    {
        $this->itemsResults = new ArrayCollection();
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
        $this->enabled = true;
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
    public function getItemType() {
        return $this->itemBank->getItemType();
    }
    
    public function addResult($examinee, $result) {
        $itemResult = new ItemResult($this->getB(), $this->getA(), $this->getC(), $this->getD());
        $itemResult->setExaminee($examinee);
        $itemResult->setItem($this);
        $itemResult->setResult($result);    
        $this->itemsResults->add($itemResult);
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
     * Set b
     *
     * @param float $b
     *
     * @return Item
     */
    public function setB($b)
    {
        $this->b = $b;

        return $this;
    }

    /**
     * Get b
     *
     * @return float
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * Set a
     *
     * @param float $a
     *
     * @return Item
     */
    public function setA($a)
    {
        $this->a = $a;

        return $this;
    }

    /**
     * Get a
     *
     * @return float
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Set c
     *
     * @param float $c
     *
     * @return Item
     */
    public function setC($c)
    {
        $this->c = $c;

        return $this;
    }

    /**
     * Get c
     *
     * @return float
     */
    public function getC()
    {
        return $this->c;
    }

    /**
     * Set d
     *
     * @param float $d
     *
     * @return Item
     */
    public function setD($d)
    {
        $this->d = $d;

        return $this;
    }

    /**
     * Get d
     *
     * @return float
     */
    public function getD()
    {
        return $this->d;
    }

    /**
     * Set itemBank
     *
     * @param \stdClass $itemBank
     *
     * @return Item
     */
    public function setItemBank($itemBank)
    {
        $this->itemBank = $itemBank;

        return $this;
    }

    /**
     * Get itemBank
     *
     * @return \stdClass
     */
    public function getItemBank()
    {
        return $this->itemBank;
    }

    /**
     * Set itemsResults
     *
     * @param \stdClass $itemsResults
     *
     * @return Item
     */
    public function setItemsResults($itemsResults)
    {
        $this->itemsResults = $itemsResults;

        return $this;
    }

    /**
     * Get itemsResults
     *
     * @return \stdClass
     */
    public function getItemsResults()
    {
        return $this->itemsResults;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Item
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Item
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
     * @return Item
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
    
    function isEnabled() {
        return $this->enabled;
    }

    function setEnabled($enabled) {
        $this->enabled = $enabled;
    }


}

