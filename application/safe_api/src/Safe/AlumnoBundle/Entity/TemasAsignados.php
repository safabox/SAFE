<?php
namespace Safe\AlumnoBundle\Entity;

use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
class TemasAsignados {
    private $disponibles;
    private $bloqueados;
    private $finalizados;
    function __construct($disponibles, $bloqueados, $finalizados) {
        $this->disponibles = $disponibles;
        $this->bloqueados = $bloqueados;
        $this->finalizados = $finalizados;
    }

    function getDisponibles() {
        return $this->disponibles;
    }

    function getBloqueados() {
        return $this->bloqueados;
    }

    function getFinalizados() {
        return $this->finalizados;
    }

    function setDisponibles($disponibles) {
        $this->disponibles = $disponibles;
    }

    function setBloqueados($bloqueados) {
        $this->bloqueados = $bloqueados;
    }

    function setFinalizados($finalizados) {
        $this->finalizados = $finalizados;
    }


}
