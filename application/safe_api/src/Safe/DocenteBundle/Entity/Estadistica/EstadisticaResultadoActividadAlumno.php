<?php
namespace Safe\DocenteBundle\Entity\Estadistica;

use Safe\TemaBundle\Entity\Actividad;
use Safe\CatBundle\Entity\Item;
use Safe\CatBundle\Entity\ItemResult;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
class EstadisticaResultadoActividadAlumno {   
    private $id;
    private $titulo;
    private $dificultad; //b
    private $discriminador; //a
    private $azar; //c
    private $d; //d
    private $fecha;
    private $estado;
    
    
    function __construct(Actividad $actividad, ItemResult $itemResult) {
        $this->id = $actividad->getId();
        $this->titulo = $actividad->getTitulo();
        if ($itemResult->getResult() != 0) {
            $this->estado = ResultadoEvaluacion::APROBADO;
        } else {
            $this->estado = ResultadoEvaluacion::DESAPROBADO;
        }               
        $this->dificultad = $itemResult->getB();
        $this->discriminador = $itemResult->getA();
        $this->azar = $itemResult->getC();
        $this->d = $itemResult->getD();
        $this->fecha = $itemResult->getCreated();
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

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getDificultad() {
        return $this->dificultad;
    }

    function setDificultad($dificultad) {
        $this->dificultad = $dificultad;
    }
    
    function getDiscriminador() {
        return $this->discriminador;
    }

    function getAzar() {
        return $this->azar;
    }

    function getD() {
        return $this->d;
    }

    function setDiscriminador($discriminador) {
        $this->discriminador = $discriminador;
    }

    function setAzar($azar) {
        $this->azar = $azar;
    }

    function setD($d) {
        $this->d = $d;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

}
