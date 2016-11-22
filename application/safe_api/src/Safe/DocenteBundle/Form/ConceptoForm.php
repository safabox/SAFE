<?php

namespace Safe\DocenteBundle\Form;


use Doctrine\Common\Collections\ArrayCollection;
use Safe\TemaBundle\Entity\Concepto;


use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;


use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\ItemType;
use Safe\CatBundle\Entity\ThetaEstimationMethodType;

class ConceptoForm
{
    /**
     * @var int
     *
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @Expose
     */
    private $titulo;
    
    /**
     * @var string
     *
     * @Expose
     */
    private $copete;

    /**
     * @var string
     *
     * @Expose
     */
    private $descripcion;

    /**
     * @var int
     *
     * @Expose
     */
    private $orden;

    /**
     * @var \DateTime
     *
     * @Expose
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @Expose
     */
    private $fechaModificacion;

    /**
     * @var bool
     *
     * @Expose
     */
    private $habilitado;
    
    /**
     * @var bool
     *
     * @Expose
     */
    private $mostrarResultado;
    
    /**
     * @Expose
     * @Groups({"docente_concepto_detalle"})
     */
    private $predecesoras;

    /**
     * @Expose
     * @Groups({"docente_concepto_detalle"}) 
     */
    private $sucesoras;

   /**
    * @Expose
    * @Groups({"docente_concepto_detalle"}) 
    */

    private $tipo;
    /**
     * @Expose
     * @Groups({"docente_concepto_detalle"}) 
     */
    
    private $rango;
    /**
     * @Expose
     * @Groups({"docente_concepto_detalle"}) 
     */
    
    private $metodo;
    /**
     * @Expose
     * @Groups({"docente_concepto_detalle"}) 
     */
    
    private $incremento;
    
    /**
     * @Expose
     *
     */
    
    private $expectativa;
    
    
    private $tema;
    
    private $concepto;
    
    private $itemBank;
    
    public function __construct()
    {
        $this->actividades = new ArrayCollection();
        $this->predecesoras = new ArrayCollection();
        $this->sucesoras = new ArrayCollection();
    }
    public function initWithConcepto(Concepto $concepto) {
        $this->titulo = $concepto->getTitulo();
        $this->copete = $concepto->getCopete();
        $this->mostrarResultado = $concepto->getMostrarResultado();
        $this->descripcion = $concepto->getDescripcion();
        $this->orden = $concepto->getOrden();
        $this->habilitado = $concepto->isHabilitado();
        $this->predecesoras = $concepto->getPredecesoras();
        $this->sucesoras = $concepto->getSucesoras();
        $this->tema = $concepto->getTema();
    }

    
    public function createConcepto() {
        $concepto = new Concepto();
        return $this->mergeConcepto($concepto);
        
    }
    
    public function mergeConcepto(Concepto $concepto) {
        $concepto->setTitulo($this->titulo);
        $concepto->setDescripcion($this->descripcion);
        $concepto->setOrden($this->orden);
        $concepto->setHabilitado($this->habilitado);
        $concepto->setMostrarResultado($this->mostrarResultado);
        $concepto->setPredecesoras($this->predecesoras);
        $concepto->setSucesoras($this->sucesoras);
        $concepto->setTema($this->tema);
        $concepto->setCopete($this->copete);
        
        return $concepto;
    }
    
    public function initWithItemBank(ItemBank $itemBank) {
        $this->tipo = $itemBank->getItemType();
        $this->rango = $itemBank->getItemRange();
        $this->metodo = $itemBank->getThetaEstimationMethod();
        $this->incremento = $itemBank->getDiscretIncrement();
        $this->expectativa = $itemBank->getExpectedTheta();
    }
    
    public function createItemBank() {
        return $this->mergeItemBank(new ItemBank());
    }
    
    public function mergeItemBank(ItemBank $itemBank) {
        $itemBank->setItemType($this->tipo);
        $itemBank->setItemRange($this->rango);
        $itemBank->setThetaEstimationMethod($this->metodo);
        $itemBank->setDiscretIncrement($this->incremento);
        $itemBank->setExpectedTheta($this->expectativa);
        return $itemBank;
    }
    
    
 
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getOrden() {
        return $this->orden;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function getHabilitado() {
        return $this->habilitado;
    }

    function getPredecesoras() {
        return $this->predecesoras;
    }

    function getSucesoras() {
        return $this->sucesoras;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getRango() {
        return $this->rango;
    }

    function getMetodo() {
        return $this->metodo;
    }

    function getIncremento() {
        return $this->incremento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    function setFechaCreacion(\DateTime $fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setFechaModificacion(\DateTime $fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    function setPredecesoras($predecesoras) {
        $this->predecesoras = $predecesoras;
    }

    function setSucesoras($sucesoras) {
        $this->sucesoras = $sucesoras;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setRango($rango) {
        $this->rango = $rango;
    }

    function setMetodo($metodo) {
        $this->metodo = $metodo;
    }

    function setIncremento($incremento) {
        $this->incremento = $incremento;
    }

    function getTema() {
        return $this->tema;
    }

    function setTema($tema) {
        $this->tema = $tema;
    }
    function getConcepto() {
        return $this->concepto;
    }

    function getItemBank() {
        return $this->itemBank;
    }

    function setConcepto($concepto) {
        $this->concepto = $concepto;
        $this->itemBank = $concepto->getItemBank();
        $this->initWithConcepto($concepto);
        $this->initWithItemBank($concepto->getItemBank());
    }

    function setItemBank($itemBank) {
        $this->itemBank = $itemBank;
    }

    
    function getCopete() {
        return $this->copete;
    }

    function setCopete($copete) {
        $this->copete = $copete;
    }
    
    function getMostrarResultado() {
        return $this->mostrarResultado;
    }

    function setMostrarResultado($mostrarResultado) {
        $this->mostrarResultado = $mostrarResultado;
    }

    function getExpectativa() {
        return $this->expectativa;
    }

    function setExpectativa($expectativa) {
        $this->expectativa = $expectativa;
    }


    
    
}

