<?php

namespace Safe\AlumnoBundle\Entity;

class TemaFinalizado {
    private $tema;
    
    private $estado;

    function __construct($tema, $estado) {
        $this->tema = $tema;
        $this->estado = $estado;
    }


    function getTema() {
        return $this->tema;
    }

    function getEstado() {
        return $this->estado;
    }

    function setTema($tema) {
        $this->tema = $tema;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


    
}
