<?php
namespace Safe\DocenteBundle\Service;

use Safe\TemaBundle\Repository\TemaRepository;

use Safe\TemaBundle\Service\TemaService;
use Safe\TemaBundle\Repository\AlumnoEstadoTemaRepository;
use Safe\DocenteBundle\Service\ConceptoImpartidoService;
use Safe\DocenteBundle\Entity\Estadistica\EstadisticaTemaAlumno;
class TemaImpartidoService extends TemaService {

    private $alumnoEstadoTemaRepository;
    private $conceptoImpartidoService;
    
    public function __construct(TemaRepository $temaRepository,
            AlumnoEstadoTemaRepository $alumnoEstadoTemaRepository,
            ConceptoImpartidoService $conceptoImpartidoService
            )
    {
         parent::__construct($temaRepository);
         $this->alumnoEstadoTemaRepository = $alumnoEstadoTemaRepository;
         $this->conceptoImpartidoService = $conceptoImpartidoService;
    }
    
    
    public function getEstadisticaAlumno($cursoId, $alumnoId) {
        $temas = $this->findAll($cursoId, null);
        $temasEstadisticas = array();
        
        foreach($temas as $tema) {
            $alumnoEstadoTema = $this->alumnoEstadoTemaRepository->findOneBy(array('tema'=> $tema, 'alumno' => $alumnoId));
            $conceptos = $this->conceptoImpartidoService->getEstadisticaAlumno($tema->getId(), $alumnoId);
            $estadisticaTemaAlumno = new EstadisticaTemaAlumno($tema, $alumnoEstadoTema, $conceptos);
            $temasEstadisticas[] = $estadisticaTemaAlumno;
        }
        return $temasEstadisticas;
    }

}
