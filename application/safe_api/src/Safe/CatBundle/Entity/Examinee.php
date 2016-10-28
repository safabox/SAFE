<?php

namespace Safe\CatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Examinee
 *
 * @ORM\Table(name="cat_examinee")
 * @ORM\Entity(repositoryClass="Safe\CatBundle\Repository\ExamineeRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class Examinee
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
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\Ability", mappedBy="examinee", cascade={"remove"}) 
     */
    private $abilities;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Safe\CatBundle\Entity\ItemResult", mappedBy="examinee", cascade={"remove"})
     */
    private $itemsResults;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    public function __construct()
    {
        $this->abilities = new ArrayCollection();
        $this->itemsResults = new ArrayCollection();
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
     * Set code
     *
     * @param string $code
     *
     * @return Examinee
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
     * Set abilities
     *
     * @param \stdClass $abilities
     *
     * @return Examinee
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
     * Set itemsResults
     *
     * @param \stdClass $itemsResults
     *
     * @return Examinee
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Examinee
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

