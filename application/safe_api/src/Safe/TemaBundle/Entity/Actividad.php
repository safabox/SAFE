<?php

namespace Safe\TemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

use Safe\CatBundle\Entity\Item;
use Safe\TemaBundle\Entity\TipoActividad;
/**
 * Actividad
 *
 * @ORM\Table(name="actividad")
 * @ORM\HasLifecycleCallbacks() 
 * @ORM\Entity(repositoryClass="Safe\TemaBundle\Repository\ActividadRepository")
 * @ExclusionPolicy("all") 
 */
class Actividad
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
     * @ORM\Column(name="tipo", type="string", length=100, nullable=false)
     * @Expose
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     * @Expose
     */
    private $descripcion;

    /**
     * @var json
     *
     * @ORM\Column(name="ejercicio", type="json", nullable=false)
     * @Expose
     * @Groups({"docente_actividad_detalle", "alumno_actividad_detalle"})
     */
    private $ejercicio;
    
    /**
     * @var json
     *
     * @ORM\Column(name="resultado", type="json", nullable=false)
     * @Expose
     * @Groups({"docente_actividad_detalle"})
     */
    private $resultado;
    
     /**
     * @var bool
     *
     * @ORM\Column(name="habilitado", type="boolean")
     * @Expose
     */
    private $habilitado;

     /**
     *
     * @ORM\ManyToOne(targetEntity="Safe\TemaBundle\Entity\Concepto", inversedBy="actividades")
     * @ORM\JoinColumn(name="concepto_id", referencedColumnName="id", nullable=false)
     */
    private $concepto;
    
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
    
    /*
     * Transient
     */
    private $item;
    
    public function __construct($titulo, $ejercicio = array(), $resultado = array(), $tipo = TipoActividad::MULTIPLE_CHOICE ,$descripcion = '', $habilitado = true)
    {
        $this->titulo = $titulo;
        $this->ejercicio = $ejercicio;
        $this->resultado = $resultado;
        $this->descripcion = $descripcion;
        $this->habilitado = $habilitado;
        $this->tipo = $tipo;
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
     * @return Actividad
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
     * @return Actividad
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
     * Set ejercicio
     *
     * @param json $ejercicio
     *
     * @return Actividad
     */
    public function setEjercicio($ejercicio)
    {
        $this->ejercicio = $ejercicio;

        return $this;
    }

    /**
     * Get ejercicio
     *
     * @return json
     */
    public function getEjercicio()
    {
        return $this->ejercicio;
    }
    
    function getResultado() {
        return $this->resultado;
    }

    function setResultado($resultado) {
        $this->resultado = $resultado;
        return $this;
    }

    
    function isHabilitado() {
        return $this->habilitado;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    function setConcepto($concepto) {
        $this->concepto = $concepto;
    }

    function setFechaCreacion(\DateTime $fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setFechaModificacion(\DateTime $fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }


    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

        //Transient
    public function getItem() {
        return $this->item;
    }
    function setItem($item) {
        $this->item = $item;
    }

   /**
    * @Groups({"docente_actividad_detalle"})
    * @VirtualProperty
    * 
    * @return float
    */
    public function getDificultad() {        
        return ($this->item != null) ? $this->item->getB() : null;
    }
    
   /**
    * @Groups({"docente_actividad_detalle"})
    * @VirtualProperty
    * 
    * @return float
    */
    public function getDiscriminador() {
        return ($this->item != null) ? $this->item->getA() : null;
    }
    
   /**
    * @Groups({"docente_actividad_detalle"})
    * @VirtualProperty    
    *
    * @return float
    */
    public function getAzar() {
        return ($this->item != null) ? $this->item->getC() : null;
    }
    
   /**
    * @Groups({"docente_actividad_detalle"}) 
    * @VirtualProperty    
    * 
    * @return float
    */
    public function getD() {
        return ($this->item != null) ? $this->item->getD() : null;
    }
            
}

