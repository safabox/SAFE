<?php

namespace Safe\TemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tema
 *
 * @ORM\Table(name="tema")
 * @ORM\Entity(repositoryClass="Safe\TemaBundle\Repository\TemaRepository")
 */
class Tema
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
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Safe\CursoBundle\Entity\Curso")
     *
     */
    private $curso;
    
     /**
     * @ORM\ManyToMany(targetEntity="Safe\TemaBundle\Entity\Tema", inversedBy="sucesoras")
     * @ORM\JoinTable(name="tema_dependencia")
     * 
     */
    private $predecesoras;

    /**
     * @ORM\ManyToMany(targetEntity="Safe\TemaBundle\Entity\Tema", mappedBy="precesoras")
     * 
     */
    private $sucesoras;

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
     * Set titulo
     *
     * @param string $titulo
     * @return Tema
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Tema
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

    /**
     * Set orden
     *
     * @param integer $orden
     * @return Tema
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }
    
    /**
     * Get curso
     *
     * @return Curso 
     */
    function getCurso() {
        return $this->curso;
    }

    /**
     * Set curso
     *
     * @param Curso $curso
     * @return Curso
     */
    function setCurso($curso) {
        $this->curso = $curso;
    }

}
