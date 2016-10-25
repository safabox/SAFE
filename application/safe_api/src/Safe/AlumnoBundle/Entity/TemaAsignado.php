<?php
namespace Safe\AlumnoBundle\Entity;

use Safe\AlumnoBundle\Entity\ProximoResultado;
class TemaAsignado {
    private $tema;
    
    private $estado;

    function __construct($tema, $estado = ProximoResultado::CURSANDO) {
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
