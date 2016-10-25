<?php
namespace Safe\AlumnoBundle\Entity;

class CursoAsignado {
    private $curso;
    private $cantTemas;
    private $cantTemasResueltos;

    function __construct($curso, $cantTemas = 0, $cantTemasResueltos = 0 ) {
        $this->curso = $curso;
        $this->cantTemas = $cantTemas;
        $this->cantTemasResueltos = $cantTemasResueltos;
    }


    
    function getCurso() {
        return $this->curso;
    }

    function getCantTemas() {
        return $this->cantTemas;
    }

    function getCantTemasResueltos() {
        return $this->cantTemasResueltos;
    }

    function setCurso($curso) {
        $this->curso = $curso;
    }

    function setCantTemas($cantTemas) {
        $this->cantTemas = $cantTemas;
    }

    function setCantTemasResueltos($cantTemasResueltos) {
        $this->cantTemasResueltos = $cantTemasResueltos;
    }


}
