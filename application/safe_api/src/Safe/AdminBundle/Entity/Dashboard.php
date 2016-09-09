<?php

namespace Safe\AdminBundle\Entity;

use Safe\AdminBundle\Entity\ItemDashboard;
class Dashboard
{
    private $cursosTotales;
    
    private $docentesTotales;
    
    private $alumnosTotales;
    
    public function __construct($cursosTotales = 0, $docentesTotales = 0, $alumnosTotales = 0)
    {
        $this->cursosTotales = $cursosTotales;
        $this->docentesTotales = $docentesTotales;        
        $this->alumnosTotales = $alumnosTotales;
    }

    public function getCursosTotales() {
        return $this->cursosTotales;
    }

    public function getAlumnosTotales() {
        return $this->alumnosTotales;
    }

    public function setCursosTotales($cursosTotales) {
        $this->cursosTotales = $cursosTotales;
    }

    public function setAlumnosTotales($alumnosTotales) {
        $this->alumnosTotales = $alumnosTotales;
    }
    
    function getDocentesTotales() {
        return $this->docentesTotales;
    }

    function setDocentesTotales($docentesTotales) {
        $this->docentesTotales = $docentesTotales;
    }




}
