<?php

namespace Safe\InstitutoBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instituto
 *
 * @ORM\Table(name="instituto")
 * @ORM\Entity(repositoryClass="Safe\InstitutoBundle\Repository\InstitutoRepository")
 * 
 */
class Instituto
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
     * @ORM\Column(name="razonSocial", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *      message = "institutoBundle.instituto.razon_social.vacio"
     * ) 
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "institutoBundle.instituto.razon_social.max"
     * )   
     */
    private $razonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;


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
     * Set razonSocial
     *
     * @param string $razonSocial
     *
     * @return Instituto
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Instituto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}

