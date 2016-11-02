<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;


/**
 * PastAbility
 *
 * @ORM\Table(name="cat_past_ability")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\PastAbilityRepository")
 * @ORM\HasLifecycleCallbacks() 
 * @ExclusionPolicy("all")
 */
class PastAbility
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
     * @ORM\Column(name="theta", type="float", nullable=false)
     * @Expose 
     */
    private $theta;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\Ability", inversedBy="pastAbilities")
     * @ORM\JoinColumn(name="ability_id", referencedColumnName="id", nullable=false)   
     */
    private $ability;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @Expose 
     */
    private $created;


    public function __construct($ability)
    {
        $this->ability = $ability;        
        $this->theta = $ability->getTheta();
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
     * Set theta
     *
     * @param float $theta
     *
     * @return PastAbility
     */
    public function setTheta($theta)
    {
        $this->theta = $theta;

        return $this;
    }

    /**
     * Get theta
     *
     * @return float
     */
    public function getTheta()
    {
        return $this->theta;
    }

    /**
     * Set ability
     *
     * @param \stdClass $ability
     *
     * @return PastAbility
     */
    public function setAbility($ability)
    {
        $this->ability = $ability;

        return $this;
    }

    /**
     * Get ability
     *
     * @return \stdClass
     */
    public function getAbility()
    {
        return $this->ability;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return PastAbility
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

