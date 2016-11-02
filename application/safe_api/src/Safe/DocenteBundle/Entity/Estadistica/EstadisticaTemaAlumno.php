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
   private $cantFinalizados;
   private $cantPendientes;
   private $cantCursando;
   function __construct(Tema $tema, AlumnoEstadoTema $alumnoEstadoTema = null, $conceptos = array()) {
       $this->id = $tema->getId();
       $this->titulo = $tema->getTitulo();
       $this->orden = $tema->getOrden();
       $this->estado = ($alumnoEstadoTema == null) ? ResultadoEvaluacion::PENDIENTE : $alumnoEstadoTema->getEstado();
       $this->cantCursando = 0;
       $this->cantFinalizados = 0;
       $this->cantPendientes = 0;
       $this->conceptos = $conceptos;
       foreach ($conceptos as $concepto) {
            if ($concepto->getEstado() === ResultadoEvaluacion::CURSANDO) {
                $this->cantCursando++;
            } else if($concepto->getEstado() === ResultadoEvaluacion::FINALIZADO) {
                $this->cantFinalizados++;
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

   function getCantFinalizados() {
       return $this->cantFinalizados;
   }

   function getCantPendientes() {
       return $this->cantPendientes;
   }

   function getCantCursando() {
       return $this->cantCursando;
   }

   function setCantFinalizados($cantFinalizados) {
       $this->cantFinalizados = $cantFinalizados;
   }

   function setCantPendientes($cantPendientes) {
       $this->cantPendientes = $cantPendientes;
   }

   function setCantCursando($cantCursando) {
       $this->cantCursando = $cantCursando;
   }



}
