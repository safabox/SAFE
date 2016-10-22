<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\ActividadRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoConceptoRepository;
use Safe\AlumnoBundle\Repository\AlumnoRepository;
use Safe\TemaBundle\Repository\ConceptoRepository;
use Safe\CatBundle\Service\CATService;

use Safe\TemaBundle\Service\ActividadService;
use Safe\AlumnoBundle\Entity\ProximoResultado;
use Safe\TemaBundle\Entity\AlumnoEstadoConcepto;
use Safe\CatBundle\Entity\ExamineeTestStatus;
use Doctrine\Common\Util\Debug;
class ActividadAsignadaService extends ActividadService {

    private $catService;
    
    private $alumnoRepository;
    
    private $conceptoRepository;
    
    private $alumnoEstadoConceptoRepository;
    
    public function __construct(ActividadRepository $actividadRepository, 
            AlumnoRepository $alumnoRepository,
            ConceptoRepository $conceptoRepository,
            AlumnoEstadoConceptoRepository $alumnoEstadoConceptoRepository, CATService $catService)
    {
        parent::__construct($actividadRepository);
        $this->alumnoRepository = $alumnoRepository;
        $this->conceptoRepository = $conceptoRepository;
        $this->alumnoEstadoConceptoRepository = $alumnoEstadoConceptoRepository;
        $this->catService = $catService;
    }
    
    public function proximaActividad($conceptoId, $alumnoId) {
        $proximoResultado = new ProximoResultado();
        $alumnoEstadoConcepto = $this->alumnoEstadoConceptoRepository->findOneBy(array('alumno'=>$alumnoId, 'concepto'=>$conceptoId));
        if ($alumnoEstadoConcepto != null) {
           return new ProximoResultado($alumnoEstadoConcepto->getEstado());
        }
        
        $examineeTestStatus = $this->catService->getExamineeStatusFor($conceptoId, $alumnoId);
        
        $estado = ProximoResultado::APROBADO;
        if (ExamineeTestStatus::APPROVED != $examineeTestStatus->getStatus()) {           
            $item = $this->catService->getNextItemFor($conceptoId, $alumnoId);
            if ($item != null){
               $actividad = $this->getById($item->getCode()); 
               $proximoResultado->setElemento($actividad);
               $estado = ProximoResultado::CURSANDO;
            } else {
               $estado = (ExamineeTestStatus::FAIL == $examineeTestStatus->getStatus()) ? ProximoResultado::DESAPROBADO : ProximoResultado::APROBADO_OBSERVACION;
            }
        }
        if ($estado != ProximoResultado::CURSANDO) {
            $alumno = $this->alumnoRepository->find($alumnoId);
            $concepto = $this->conceptoRepository->find($conceptoId);
            $aprobado = (ProximoResultado::DESAPROBADO != $estado);
            $alumnoEstadoConcepto = new AlumnoEstadoConcepto($alumno, $concepto, $aprobado, $estado);
            $this->alumnoEstadoConceptoRepository->crearOActualizar($alumnoEstadoConcepto);
        }
        
        $proximoResultado->setEstado($estado);
        return $proximoResultado;
    }
    
    
    
}
