<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * ItemResult
 *
 * @ORM\Table(name="cat_item_result")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\ItemResultRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class ItemResult
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\Item", inversedBy="itemsResults")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    private $item;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\Examinee", inversedBy="itemsResults")
     * @ORM\JoinColumn(name="examinee_id", referencedColumnName="id", nullable=false)
     */
    private $examinee;

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
     * @var int
     *
     * @ORM\Column(name="result", type="integer", nullable=false)
     */
    private $result;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;


    //https://en.wikipedia.org/wiki/Item_response_theory#IRT_models
    public function __construct($b=0, $a=1, $c=0, $d=1)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
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
    
    function getItemType() {
        return $this->item->getItemBank()->getItemType();
    }
    public static function fromItem($examinee, $item, $result) {
        $instance = new ItemResult($item->getB(), $item->getA(), $item->getC(), $item->getD());
        $instance->setExaminee($examinee);
        $instance->setItem($item);
        $instance->setResult($result);        
        return $instance;
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
     * Set item
     *
     * @param \stdClass $item
     *
     * @return ItemResult
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \stdClass
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set examinee
     *
     * @param \stdClass $examinee
     *
     * @return ItemResult
     */
    public function setExaminee($examinee)
    {
        $this->examinee = $examinee;

        return $this;
    }

    /**
     * Get examinee
     *
     * @return \stdClass
     */
    public function getExaminee()
    {
        return $this->examinee;
    }

    /**
     * Set b
     *
     * @param float $b
     *
     * @return ItemResult
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
     * @return ItemResult
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
     * @return ItemResult
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
     * @return ItemResult
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
     * Set result
     *
     * @param integer $result
     *
     * @return ItemResult
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ItemResult
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
}

