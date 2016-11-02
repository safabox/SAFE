<?php
namespace Safe\DocenteBundle\Service;

use Safe\AlumnoBundle\Service\AlumnoService;
use Safe\AlumnoBundle\Repository\AlumnoRepository;
use Safe\DocenteBundle\Service\TemaImpartidoService;
use Safe\DocenteBundle\Entity\Estadistica\EstadisticaAlumno;
class AlumnoAsignadoService extends AlumnoService {
    
    private $temaImpartidoService;
    
    public function __construct(AlumnoRepository $alumnoRepository, TemaImpartidoService $temaImpartidoService)
    {
         parent::__construct($alumnoRepository);
         $this->temaImpartidoService = $temaImpartidoService;
    }
    
    
    public function getEstadisticaAlumno($alumnoId, $cursoId) {
        $alumno = $this->getById($alumnoId);
        $temasEstadisticas = $this->temaImpartidoService->getEstadisticaAlumno($cursoId, $alumnoId);
        return new EstadisticaAlumno($alumno, $temasEstadisticas);
    }

}
