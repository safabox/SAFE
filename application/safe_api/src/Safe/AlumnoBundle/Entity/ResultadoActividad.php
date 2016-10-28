<?php

namespace Safe\AlumnoBundle\Entity;

use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
class ResultadoActividad {
    private $resultado;
    private $proximaActividad;

    function __construct($resultado, $proximaActividad) {
        $this->resultado = $resultado;
        $this->proximaActividad = $proximaActividad;
    }


    function getResultado() {
        return $this->resultado;
    }

    function getProximaActividad() {
        return $this->proximaActividad;
    }

    function setResultado($resultado) {
        $this->resultado = $resultado;
    }

    function setProximaActividad($proximaActividad) {
        $this->proximaActividad = $proximaActividad;
    }


}
