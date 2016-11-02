<?php
namespace Safe\DocenteBundle\Entity\Estadistica;

use Safe\AlumnoBundle\Entity\Alumno;
use Safe\DocenteBundle\Entity\Estadistica\EstadisticaTemaAlumno;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
class EstadisticaAlumno {
    private $id;
    private $nombre;
    private $legajo;
    private $temas;
    
    private $cantFinalizados;
    private $cantPendientes;
    private $cantCursando;
    
    function __construct(Alumno $alumno, $temas = array()) {
        $this->id = $alumno->getId();
        $this->nombre = $alumno->getUsuario()->getNombre();
        $this->legajo = $alumno->getLegajo();
        $this->temas = $temas;
        $this->cantCursando = 0;
        $this->cantFinalizados = 0;
        $this->cantPendientes = 0;
        foreach ($temas as $tema) {
            if ($tema->getEstado() === ResultadoEvaluacion::CURSANDO) {
                $this->cantCursando++;
            } else if($tema->getEstado() === ResultadoEvaluacion::FINALIZADO) {
                $this->cantFinalizados++;
            } else {
                $this->cantPendientes++;
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getLegajo() {
        return $this->legajo;
    }

    function getTemas() {
        return $this->temas;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setLegajo($legajo) {
        $this->legajo = $legajo;
    }

    function setTemas($temas) {
        $this->temas = $temas;
    }


    function getCantFinalizados() {
        return $this->cantFinalizados;
    }

    function getCantPendientes() {
        return $this->cantPendientes;
    }

    function getCantCursando() {
        return $this->cantCursando;
    }

    function setCantFinalizados($cantFinalizados) {
        $this->cantFinalizados = $cantFinalizados;
    }

    function setCantPendientes($cantPendientes) {
        $this->cantPendientes = $cantPendientes;
    }

    function setCantCursando($cantCursando) {
        $this->cantCursando = $cantCursando;
    }


}
