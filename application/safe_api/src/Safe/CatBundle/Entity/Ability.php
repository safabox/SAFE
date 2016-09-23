<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Examinee
 *
 * @ORM\Table(name="cat_examinee")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\AbilityRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class Ability {
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
     * 
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\Examinee", inversedBy="abilities")
     * @ORM\JoinColumn(name="examinee_id", referencedColumnName="id", nullable=FALSE)    
     */
    private $examinee;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\ItemBank", inversedBy="abilities")
     * @ORM\JoinColumn(name="item_bank_id", referencedColumnName="id", nullable=FALSE)    
     */
    private $itemBank;
    
    /**
     * @var float
     * @ORM\Column(name="theta", type="float")  
     * dificultad -3 < b < 3
     */
    private $theta;
    
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

    function getExaminee() {
        return $this->examinee;
    }

    function getTheta() {
        return $this->theta;
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

    function setExaminee($examinee) {
        $this->examinee = $examinee;
    }

    function setTheta($theta) {
        $this->theta = $theta;
    }

    function setCreated(\DateTime $created) {
        $this->created = $created;
    }

    function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
    }

    function getItemBank() {
        return $this->itemBank;
    }

    function setItemBank($itemBank) {
        $this->itemBank = $itemBank;
    }




}
