<?php

namespace Safe\AlumnoBundle\Entity;

class ConceptoFinalizado {
    private $concepto;
    
    private $estado;

    function __construct($concepto, $estado) {
        $this->concepto = $concepto;
        $this->estado = $estado;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getEstado() {
        return $this->estado;
    }

    function setConcepto($concepto) {
        $this->concepto = $concepto;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


    
}
