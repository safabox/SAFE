<?php

namespace Safe\TemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * Tema
 *
 * @ORM\Table(name="tema")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Safe\TemaBundle\Repository\TemaRepository")
 * @ExclusionPolicy("all") 
 */
class Tema
{
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
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     * @Expose
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     * @Expose
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="orden", type="integer")
     * @Expose
     */
    private $orden;
        
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=true)
     * @Expose
     */
    private $fechaCreacion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     * @Expose
     */
    private $fechaModificacion;

     /**
     * @ORM\ManyToMany(targetEntity="Safe\TemaBundle\Entity\Tema", inversedBy="sucesoras")
     * @ORM\JoinTable(name="tema_dependencia",
     *     joinColumns={@ORM\JoinColumn(name="sucesora_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="predecesora_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"orden" = "ASC"})
     * @Expose
     * @Groups({"docente_tema_detalle"})
     */
    private $predecesoras;

    /**
     * @ORM\ManyToMany(targetEntity="Safe\TemaBundle\Entity\Tema", mappedBy="predecesoras")
     * @ORM\OrderBy({"orden" = "ASC"}) 
     * @Expose
     * @Groups({"docente_tema_detalle"}) 
     */
    private $sucesoras;
    
    /**
     * @ORM\Column(name="habilitado", type="boolean")
     * 
     * @Expose
     * @var boolean
     */
    private $habilitado;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Safe\CursoBundle\Entity\Curso", inversedBy="items")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id", nullable=false)
     */
    private $curso;

    
    public function __construct()
    {
        $this->predecesoras = new ArrayCollection();
        $this->sucesoras = new ArrayCollection();
        $this->setFechaCreacion(new \DateTime());
    }   
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function actualizarFechaModificacion() {
        $this->setFechaModificacion(new \DateTime());
    }
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
    
    function getPredecesoras() {
        return $this->predecesoras;
    }

    function getSucesoras() {
        return $this->sucesoras;
    }

    function setPredecesoras($predecesoras) {
        $this->predecesoras = $predecesoras;
    }

    function setSucesoras($sucesoras) {
        $this->sucesoras = $sucesoras;
    }
    
    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function setFechaCreacion(\DateTime $fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setFechaModificacion(\DateTime $fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }


    function isHabilitado() {
        return $this->habilitado;
    }

    function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

 
}
