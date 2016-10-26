<?php
namespace Safe\AlumnoBundle\Entity;

class TemaProximaActividad {
    private $tema;
    private $concepto;
    private $actividad;

    function __construct($tema, $concepto, $actividad) {
        $this->tema = $tema;
        $this->concepto = $concepto;
        $this->actividad = $actividad;
    }


    function getTema() {
        return $this->tema;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getActividad() {
        return $this->actividad;
    }

    function setTema($tema) {
        $this->tema = $tema;
    }

    function setConcepto($concepto) {
        $this->concepto = $concepto;
    }

    function setActividad($actividad) {
        $this->actividad = $actividad;
    }


}
