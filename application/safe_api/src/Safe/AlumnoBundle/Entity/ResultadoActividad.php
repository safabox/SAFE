<?php

namespace Safe\AlumnoBundle\Entity;

use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
class ResultadoActividad {
    private $resultado;
    private $proximaActividad;
    private $resolucionAnterior;

    function __construct($resultado, $proximaActividad, $resolucionAnterior) {
        $this->resultado = $resultado;
        $this->proximaActividad = $proximaActividad;
        $this->resolucionAnterior = $resolucionAnterior;
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

    function getResolucionAnterior() {
        return $this->resolucionAnterior;
    }

    function setResolucionAnterior($resolucionAnterior) {
        $this->resolucionAnterior = $resolucionAnterior;
    }

    

}
