<?php
namespace Safe\DocenteBundle\Entity\Estadistica;

use Safe\TemaBundle\Entity\Actividad;
use Safe\CatBundle\Entity\Item;
use Safe\CatBundle\Entity\ItemResult;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
class EstadisticaResultadoActividadAlumno {   
    private $id;
    private $titulo;
    private $estado;
    
    function __construct(Actividad $actividad, ItemResult $itemResult) {
        $this->id = $actividad->getId();
        $this->titulo = $actividad->getTitulo();
        if ($itemResult->getResult() != 0) {
            $this->estado = ResultadoEvaluacion::APROBADO;
        } else {
            $this->estado = ResultadoEvaluacion::DESAPROBADO;
        }                
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


}
