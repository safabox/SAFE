<?php
namespace Safe\AlumnoBundle\Entity;

class ProximoResultado {
    const APROBADO = 'APROBADO';
    const APROBADO_OBSERVACION = 'APROBADO_OBSERVACION';
    const DESAPROBADO = 'DESAPROBADO';
    const CURSANDO = 'CURSANDO';
           
    
    private $estado;

    private $mensaje;
        
    private $elemento;
    
    function __construct($estado = ProximoResultado::CURSANDO, $elemento=null, $mensaje='') {
        $this->elemento = $elemento;        
        $this->estado = $estado;
        $this->mensaje = $mensaje;        
    }
    
    function getEstado() {
        return $this->estado;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function getElemento() {
        return $this->elemento;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    function setElemento($elemento) {
        $this->elemento = $elemento;
    }



}
