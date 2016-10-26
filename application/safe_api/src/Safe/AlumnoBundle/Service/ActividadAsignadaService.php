<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\ActividadRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoConceptoRepository;
use Safe\AlumnoBundle\Repository\AlumnoRepository;
use Safe\TemaBundle\Repository\ConceptoRepository;
use Safe\CatBundle\Service\CATService;

use Safe\TemaBundle\Service\ActividadService;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
use Safe\TemaBundle\Entity\AlumnoEstadoConcepto;
use Safe\CatBundle\Entity\ExamineeTestStatus;
use Safe\TemaBundle\Entity\Evaluador\EvaluadorActividad;
use Safe\TemaBundle\Entity\Evaluador\EvaluadorFactory;
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
    
    public function registrarResultado($actividadId, $resultado) {
        $actividad = $this->getById($actividadId);
        $evaluador = EvaluadorFactory::crearEvaluador($actividad->getTipo());
        $resultadoEvaluacion = $evaluador->evaluar($actividad->getResultado(), $resultado);
        
        //$this->$catService->
    }
    
    public function proximaActividad($conceptoId, $alumnoId) {
        $proximoResultado = new ResultadoEvaluacion();
        $alumnoEstadoConcepto = $this->alumnoEstadoConceptoRepository->findOneBy(array('alumno'=>$alumnoId, 'concepto'=>$conceptoId));
        if ($alumnoEstadoConcepto != null) {
           return new ResultadoEvaluacion($alumnoEstadoConcepto->getEstado());
        }
        
        $examineeTestStatus = $this->catService->getExamineeStatusFor($conceptoId, $alumnoId);
        
        $estado = ResultadoEvaluacion::APROBADO;
        if (ExamineeTestStatus::APPROVED != $examineeTestStatus->getStatus()) {           
            $item = $this->catService->getNextItemFor($conceptoId, $alumnoId);
            if ($item != null){
               $actividad = $this->getById($item->getCode()); 
               $proximoResultado->setElemento($actividad);
               $estado = ResultadoEvaluacion::CURSANDO;
            } else {
               $estado = (ExamineeTestStatus::FAIL == $examineeTestStatus->getStatus()) ? ResultadoEvaluacion::DESAPROBADO : ResultadoEvaluacion::APROBADO_OBSERVACION;
            }
        }
        if ($estado != ResultadoEvaluacion::CURSANDO) {
            $alumno = $this->alumnoRepository->find($alumnoId);
            $concepto = $this->conceptoRepository->find($conceptoId);
            $aprobado = (ResultadoEvaluacion::DESAPROBADO != $estado);
            $alumnoEstadoConcepto = new AlumnoEstadoConcepto($alumno, $concepto, $aprobado, $estado);
            $this->alumnoEstadoConceptoRepository->crearOActualizar($alumnoEstadoConcepto);
        }
        
        $proximoResultado->setEstado($estado);
        return $proximoResultado;
    }
    
    
    
}
