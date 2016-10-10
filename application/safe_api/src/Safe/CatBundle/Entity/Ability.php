<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Safe\CatBundle\EntityPastAbility;
/**
 * Ability
 *
 * @ORM\Table(name="cat_ability")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\AbilityRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ability
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
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\Examinee", inversedBy="abilities")
     * @ORM\JoinColumn(name="examinee_id", referencedColumnName="id", nullable=false) 
     */
    private $examinee;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Safe\CatBundle\Entity\ItemBank", inversedBy="abilities")
     * @ORM\JoinColumn(name="item_bank_id", referencedColumnName="id", nullable=false)    
     */
    private $itemBank;

    /**
     * @var float
     *
     * @ORM\Column(name="theta", type="float", nullable=false)
     */
    private $theta;

    /**
     *
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\PastAbility", mappedBy="ability", cascade={"remove", "persist"})
     */
    private $pastAbilities;

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


    public function __construct($examinee, $itemBank, $theta)
    {
        $this->pastAbilities = new ArrayCollection();
        $this->examinee = $examinee;
        $this->itemBank = $itemBank;
        $this->theta = $theta;
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
    
    public function updateTheta($newTheta) {
        $pastAbility = new PastAbility($this);
        $this->pastAbilities->add($pastAbility);
        $this->setTheta($newTheta);
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
     * Set examinee
     *
     * @param \stdClass $examinee
     *
     * @return Ability
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
     * Set itemBank
     *
     * @param \stdClass $itemBank
     *
     * @return Ability
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
     * Set theta
     *
     * @param float $theta
     *
     * @return Ability
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
     * Set pastAbilities
     *
     * @param \stdClass $pastAbilities
     *
     * @return Ability
     */
    public function setPastAbilities($pastAbilities)
    {
        $this->pastAbilities = $pastAbilities;

        return $this;
    }

    /**
     * Get pastAbilities
     *
     * @return \stdClass
     */
    public function getPastAbilities()
    {
        return $this->pastAbilities;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Ability
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
     * @return Ability
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
}

