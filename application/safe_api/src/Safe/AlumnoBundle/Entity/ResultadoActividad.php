<?php

namespace Safe\AlumnoBundle\Entity;

use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
class ResultadoActividad {
    private $resultado;
    private $proximaActividad;
    private $resultadoEsperado;

    function __construct($resultado, $proximaActividad, $resultadoEsperado) {
        $this->resultado = $resultado;
        $this->proximaActividad = $proximaActividad;
        $this->resultadoEsperado = $resultadoEsperado;
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
    
    

    function getResultadoEsperado() {
        return $this->resultadoEsperado;
    }

    function setResultadoEsperado($resultadoEsperado) {
        $this->resultadoEsperado = $resultadoEsperado;
    }


}
