<?php
namespace Safe\DocenteBundle\Entity\Estadistica;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

use Safe\TemaBundle\Entity\Concepto;
use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\Ability;
use Safe\TemaBundle\Entity\AlumnoEstadoConcepto;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;

/**
 * @ExclusionPolicy("all")
 */
class EstadisticaConceptoAlumno {
  /**
   * @Expose 
   */  
   private $id;
  /**
   * @Expose 
   */  
   private $titulo;
  /**
   * @Expose 
   */   
   private $orden;
  /**
   * @Expose 
   */   
   private $thetaEsperado;
  /**
   * @Expose 
   */   
   private $incremento;
  /**
   * @Expose 
   */   
   private $rango;
  /**
   * @Expose 
   */   
   private $thetaMetodo;
  /**
   * @Expose 
   */   
   private $theta;
   /**
   * @Expose 
   */  
   private $thetaError;
   /**
   * @Expose 
   */  
   private $estado;   
   /**
   * @Expose 
   */  
   private $fechaActualizacion;
   /**
   * @Expose 
   * @Groups({"docente_estadistica_detalle"})
   */  
   private $resultados;

   /**
   * @Expose 
   * @Groups({"docente_estadistica_detalle"})
   */  
   private $thetasAnteriores;
   
   function __construct(Concepto $concepto, ItemBank $itemBank, Ability $ability = null, AlumnoEstadoConcepto $alumnoEstadoConcepto = null, $resultados = array(), $completo = false) {
       $this->id = $concepto->getId();
       $this->titulo = $concepto->getTitulo();
       $this->orden = $concepto->getOrden();
       $this->thetaEsperado = $itemBank->getExpectedTheta();
       $this->incremento = $itemBank->getDiscretIncrement();
       $this->thetaMetodo = $itemBank->getThetaEstimationMethod();
       $this->rango = $itemBank->getItemRange();
       $this->estado = ($alumnoEstadoConcepto == null)? ResultadoEvaluacion::PENDIENTE : $alumnoEstadoConcepto->getEstado();
       if ($ability != null) {
            $this->theta = $ability->getTheta();
            $this->thetaError = $ability->getUnsignedThetaError();       
            $this->fechaActualizacion = $ability->getUpdated();    
       } else {
            $this->theta = -99;
            $this->thetaError = 99;       
            $this->fechaActualizacion = new \DateTime(); 
       }
       $this->resultados = $resultados;
       
       $this->thetasAnteriores = ($completo && $ability != null) ? $ability->getPastAbilities() : array();
   }

   
   function getId() {
       return $this->id;
   }

   function getTitulo() {
       return $this->titulo;
   }

   function getEstado() {
       return $this->estado;
   }

   function getOrden() {
       return $this->orden;
   }

   function getThetaEsperado() {
       return $this->thetaEsperado;
   }

   function getMetodo() {
       return $this->metodo;
   }

   function getRango() {
       return $this->rango;
   }

   function getTheta() {
       return $this->theta;
   }

   function getThetaError() {
       return $this->thetaError;
   }

   function getFechaActualizacion() {
       return $this->fechaActualizacion;
   }

   function setId($id) {
       $this->id = $id;
   }

   function setTitulo($titulo) {
       $this->titulo = $titulo;
   }

   function setEstado($estado) {
       $this->estado = $estado;
   }

   function setOrden($orden) {
       $this->orden = $orden;
   }

   function setThetaEsperado($thetaEsperado) {
       $this->thetaEsperado = $thetaEsperado;
   }

   function setMetodo($metodo) {
       $this->metodo = $metodo;
   }

   function setRango($rango) {
       $this->rango = $rango;
   }

   function setTheta($theta) {
       $this->theta = $theta;
   }

   function setThetaError($thetaError) {
       $this->thetaError = $thetaError;
   }

   function setFechaActualizacion($fechaActualizacion) {
       $this->fechaActualizacion = $fechaActualizacion;
   }
   function getIncremento() {
       return $this->incremento;
   }

   function setIncremento($incremento) {
       $this->incremento = $incremento;
   }

   function getThetaMetodo() {
       return $this->thetaMetodo;
   }

   function getResultados() {
       return $this->resultados;
   }

   function setThetaMetodo($thetaMetodo) {
       $this->thetaMetodo = $thetaMetodo;
   }

   function setResultados($resultados) {
       $this->resultados = $resultados;
   }

   function getThetasAnteriores() {
       return $this->thetasAnteriores;
   }

   function setThetasAnteriores($thetasAnteriores) {
       $this->thetasAnteriores = $thetasAnteriores;
   }



}
