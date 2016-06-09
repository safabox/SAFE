<?php

namespace Safe\DocenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docente
 *
 * @ORM\Table(name="docente")
 * @ORM\Entity(repositoryClass="Safe\DocenteBundle\Repository\DocenteRepository")
 */
class Docente
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="curriculum", type="text", nullable=true)
     */
    private $curriculum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Docente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellido
     * @return Docente
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set curriculum
     *
     * @param string $curriculum
     * @return Docente
     */
    public function setCurriculum($curriculum)
    {
        $this->curriculum = $curriculum;

        return $this;
    }

    /**
     * Get curriculum
     *
     * @return string 
     */
    public function getCurriculum()
    {
        return $this->curriculum;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Docente
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }
}
