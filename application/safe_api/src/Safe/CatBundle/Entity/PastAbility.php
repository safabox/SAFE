<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Examinee
 *
 * @ORM\Table(name="cat_past_ability")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\PastAbilityRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class PastAbility {
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
     * @ORM\Column(name="theta", type="float")  
     * dificultad -3 < b < 3
     */
    private $theta;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\Ability", inversedBy="pastAbilities")
     * @ORM\JoinColumn(name="ability_id", referencedColumnName="id", nullable=FALSE)    
     */
    private $ability;
    
    /**
    * @var \DateTime
    *
    * @ORM\Column(name="created", type="datetime", nullable=false)
    * @Expose
    */
    private $created;
    
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

    function getTheta() {
        return $this->theta;
    }

    function getAbility() {
        return $this->ability;
    }

    function getCreated() {
        return $this->created;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTheta($theta) {
        $this->theta = $theta;
    }

    function setAbility($ability) {
        $this->ability = $ability;
    }

    function setCreated(\DateTime $created) {
        $this->created = $created;
    }


}
