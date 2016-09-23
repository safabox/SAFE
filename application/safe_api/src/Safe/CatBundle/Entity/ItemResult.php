<?php
namespace Safe\CatBundle\Entity;

use Safe\CatBundle\Entity\Item;
use Safe\CatBundle\Entity\ItemModel;
use Safe\CatBundle\Entity\IrtEquations;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instituto
 *
 * @ORM\Table(name="cat_item_result")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\ItemResultRepository")
 * 
 */
class ItemResult {
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\Item", inversedBy="itemsResults")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=FALSE)
     */
    private $item;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\Item", inversedBy="itemsResults")
     * @ORM\JoinColumn(name="examinee_id", referencedColumnName="id", nullable=FALSE)
     */
    private $examinee;
        
    
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
     * @var int
     *
     * @ORM\Column(name="result", type="integer", nullable=FALSE)
     * 1 OK
     * 0 KO
     */
    private $result;
    
   /**
    * @var \DateTime
    *
    * @ORM\Column(name="created", type="datetime", nullable=false)
    * @Expose
    */
    private $created;
    
    //https://en.wikipedia.org/wiki/Item_response_theory#IRT_models
    public function __construct()
    {
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
        if ($this->getCreated() == NULL) {
            $this->setCreated(new \DateTime());
        }
    }
    
    function getId() {
        return $this->id;
    }

    function getExaminee() {
        return $this->examinee;
    }
    
    function getItemType() {
        return $this->itemBank->getItemType();
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

    function getResult() {
        return $this->result;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setExaminee($examinee) {
        $this->examinee = $examinee;
    }

    function setItem($item) {
        $this->item = $item;
    }

    function setItemType($itemType) {
        $this->itemType = $itemType;
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

    function setResult($result) {
        $this->result = $result;
    }


    function getCreated() {
        return $this->created;
    }

    function setCreated(\DateTime $created) {
        $this->created = $created;
    }


}
