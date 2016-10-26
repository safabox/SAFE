<?php

namespace Safe\AlumnoBundle\Entity;

class ConceptoProximaActividad {
    
    private $concepto;
    
    private $actividad;

    function __construct($concepto, $actividad) {
        $this->concepto = $concepto;
        $this->actividad = $actividad;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getActividad() {
        return $this->actividad;
    }

    function setConcepto($concepto) {
        $this->concepto = $concepto;
    }

    function setActividad($actividad) {
        $this->actividad = $actividad;
    }


}
