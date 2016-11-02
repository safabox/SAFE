<?php
namespace Safe\DocenteBundle\Entity\Estadistica;

use Safe\TemaBundle\Entity\Concepto;
use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\Ability;
use Safe\TemaBundle\Entity\AlumnoEstadoConcepto;
use Safe\DocenteBundle\Entity\Estadistica\EstadisticaConceptoAlumno;
use Safe\TemaBundle\Entity\Tema;
use Safe\TemaBundle\Entity\AlumnoEstadoTema;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
class EstadisticaTemaAlumno {
   private $id;
   private $titulo;
   private $orden;
   private $estado;   
   private $conceptos;
   private $cantCursando;
   private $cantAprobados;
   private $cantAprobadosObservaciones;
   private $cantDesaprobados;
   private $cantPendientes;
   
   function __construct(Tema $tema, AlumnoEstadoTema $alumnoEstadoTema = null, $conceptos = array()) {
       $this->id = $tema->getId();
       $this->titulo = $tema->getTitulo();
       $this->orden = $tema->getOrden();
       $this->estado = ($alumnoEstadoTema == null) ? ResultadoEvaluacion::PENDIENTE : $alumnoEstadoTema->getEstado();
       $this->cantCursando = 0;
       $this->cantAprobados = 0;       
       $this->cantAprobadosObservaciones = 0;
       $this->cantDesaprobados = 0;
       $this->cantPendientes = 0;
       $this->conceptos = $conceptos;
       foreach ($conceptos as $concepto) {
            if ($concepto->getEstado() === ResultadoEvaluacion::CURSANDO) {
                $this->cantCursando++;
            } else if($concepto->getEstado() === ResultadoEvaluacion::APROBADO) {
                $this->cantAprobados++;
            } else if($concepto->getEstado() === ResultadoEvaluacion::APROBADO_OBSERVACION) { 
                $this->cantAprobadosObservaciones++;
            } else if($concepto->getEstado() === ResultadoEvaluacion::DESAPROBADO) { 
                $this->cantDesaprobados++;
            } else {
                $this->cantPendientes++;
            }
        }
       
   }
   function getId() {
       return $this->id;
   }

   function getTitulo() {
       return $this->titulo;
   }

   function getOrden() {
       return $this->orden;
   }

   function getEstado() {
       return $this->estado;
   }

   function getConceptos() {
       return $this->conceptos;
   }

   function getCantCursando() {
       return $this->cantCursando;
   }

   function getCantAprobados() {
       return $this->cantAprobados;
   }

   function getCantAprobadosObservaciones() {
       return $this->cantAprobadosObservaciones;
   }

   function getCantDesaprobados() {
       return $this->cantDesaprobados;
   }

   function getCantPendientes() {
       return $this->cantPendientes;
   }

   function setId($id) {
       $this->id = $id;
   }

   function setTitulo($titulo) {
       $this->titulo = $titulo;
   }

   function setOrden($orden) {
       $this->orden = $orden;
   }

   function setEstado($estado) {
       $this->estado = $estado;
   }

   function setConceptos($conceptos) {
       $this->conceptos = $conceptos;
   }

   function setCantCursando($cantCursando) {
       $this->cantCursando = $cantCursando;
   }

   function setCantAprobados($cantAprobados) {
       $this->cantAprobados = $cantAprobados;
   }

   function setCantAprobadosObservaciones($cantAprobadosObservaciones) {
       $this->cantAprobadosObservaciones = $cantAprobadosObservaciones;
   }

   function setCantDesaprobados($cantDesaprobados) {
       $this->cantDesaprobados = $cantDesaprobados;
   }

   function setCantPendientes($cantPendientes) {
       $this->cantPendientes = $cantPendientes;
   }


}
