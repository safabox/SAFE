<?php

namespace Safe\TemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * Concepto
 *
 * @ORM\Table(name="concepto")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Safe\TemaBundle\Repository\ConceptoRepository")
 * @ExclusionPolicy("all") 
 */
class Concepto
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
     * @ORM\Column(name="orden", type="integer", nullable=true)
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
     * @var bool
     *
     * @ORM\Column(name="habilitado", type="boolean")
     * @Expose
     */
    private $habilitado;
    
    /**
     * @ORM\ManyToMany(targetEntity="Safe\TemaBundle\Entity\Concepto", inversedBy="sucesoras")
     * @ORM\JoinTable(name="concepto_dependencia",
     *     joinColumns={@ORM\JoinColumn(name="sucesora_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="predecesora_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"orden" = "ASC"})
     * @Expose
     * @Groups({"docente_concepto_detalle"})
     */
    private $predecesoras;

    /**
     * @ORM\ManyToMany(targetEntity="Safe\TemaBundle\Entity\Concepto", mappedBy="predecesoras")
     * @ORM\OrderBy({"orden" = "ASC"}) 
     * @Expose
     * @Groups({"docente_concepto_detalle"}) 
     */
    private $sucesoras;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Safe\TemaBundle\Entity\Tema", inversedBy="conceptos")
     * @ORM\JoinColumn(name="tema_id", referencedColumnName="id", nullable=false)
     */
    private $tema;
    
    
    public function __construct()
    {
        $this->predecesoras = new ArrayCollection();
        $this->sucesoras = new ArrayCollection();
        $this->setFechaCreacion(new \DateTime());
        $this->habilitado = true;
        $this->orden = 0;
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Concepto
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
     *
     * @return Concepto
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
     *
     * @return Concepto
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return int
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Concepto
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return Concepto
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

    /**
     * Set habilitado
     *
     * @param boolean $habilitado
     *
     * @return Concepto
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;

        return $this;
    }

    /**
     * Get habilitado
     *
     * @return bool
     */
    public function isHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * Set tema
     *
     * @param \stdClass $tema
     *
     * @return Concepto
     */
    public function setTema($tema)
    {
        $this->tema = $tema;

        return $this;
    }

    /**
     * Get tema
     *
     * @return \stdClass
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * Set sucesoras
     *
     * @param \stdClass $sucesoras
     *
     * @return Concepto
     */
    public function setSucesoras($sucesoras)
    {
        $this->sucesoras = $sucesoras;

        return $this;
    }

    /**
     * Get sucesoras
     *
     * @return \stdClass
     */
    public function getSucesoras()
    {
        return $this->sucesoras;
    }

    /**
     * Set predecesoras
     *
     * @param \stdClass $predecesoras
     *
     * @return Concepto
     */
    public function setPredecesoras($predecesoras)
    {
        $this->predecesoras = $predecesoras;

        return $this;
    }

    /**
     * Get predecesoras
     *
     * @return \stdClass
     */
    public function getPredecesoras()
    {
        return $this->predecesoras;
    }
}
