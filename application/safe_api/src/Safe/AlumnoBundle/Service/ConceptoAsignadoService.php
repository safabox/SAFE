<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\ConceptoRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoConceptoRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoTemaRepository;
use Safe\AlumnoBundle\Repository\AlumnoRepository;
use Safe\TemaBundle\Repository\TemaRepository;

use Safe\TemaBundle\Service\ConceptoService;

use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
use Safe\TemaBundle\Entity\AlumnoEstadoTema;
use Doctrine\Common\Util\Debug;
use Safe\AlumnoBundle\Entity\ConceptoFinalizado;
use Safe\AlumnoBundle\Entity\ConceptosAsignados;
use Safe\AlumnoBundle\Entity\ConceptoProximaActividad;
use Safe\AlumnoBundle\Service\ActividadAsignadaService;
class ConceptoAsignadoService extends ConceptoService {

    private $alumnoRepository;
    
    private $temaRepository;
    
    private $alumnoEstadoConceptoRepository;
    
    private $alumnoEstadoTemaRepository;
    
    private $actividadAsignadaService;
    
    public function __construct(ConceptoRepository $conceptoRepository,
            AlumnoRepository $alumnoRepository, TemaRepository $temaRepository, 
            AlumnoEstadoConceptoRepository $alumnoEstadoConceptoRepository,
            AlumnoEstadoTemaRepository $alumnoEstadoTemaRepository,
            ActividadAsignadaService $actividadAsignadaService            
            )
    {
        parent::__construct($conceptoRepository);
        $this->alumnoEstadoConceptoRepository = $alumnoEstadoConceptoRepository;
        $this->alumnoRepository = $alumnoRepository;
        $this->temaRepository = $temaRepository;
        $this->alumnoEstadoTemaRepository = $alumnoEstadoTemaRepository;
        $this->actividadAsignadaService = $actividadAsignadaService;
    }
    
    public function findAll($alumnoId, $temaId, $limit = null, $offset = 0) {
        $result = $this->obtenerHabilitados($alumnoId, $temaId, true, $limit, $offset);
        $finalizados = $this->obtenerHabilitados($alumnoId, $temaId, false, $limit, $offset);
        $disponibles = array();
        $bloqueados = array();
        
        foreach ($result as $concepto) {
            $predecesorasFinalizadas = $this->countPredecesorasFinalizadas($concepto, $alumnoId);
            $cantidadPredecesoras = $concepto->getPredecesoras()->count();
            if ($predecesorasFinalizadas >= $cantidadPredecesoras) {
                $disponibles[] = $concepto;
            } else {
                $bloqueados[] = $concepto;
            }
        }
        $finalizadosConEstados = array();
        foreach($finalizados as $finalizado) {
            $estados = $this->getAlumnoEstadoConcepto($alumnoId, $finalizado->getId());
            if (count($estados) > 0) {
                $estado = $estados[0]->getEstado();
            } else {
                $estado = ResultadoEvaluacion::FINALIZADO;
            }
            $finalizadosConEstados[] = new ConceptoFinalizado($finalizado, $estado);
        }
        
        return new ConceptosAsignados($disponibles, $bloqueados, $finalizadosConEstados);
    }
    
    
    public function proximoConcepto($temaId, $alumnoId) {
        
        $alumnoEstadoTema = $this->alumnoEstadoTemaRepository->findOneBy(array('tema'=> $temaId, 'alumno' => $alumnoId));
        if ($alumnoEstadoTema != null) {
            return new ResultadoEvaluacion($alumnoEstadoTema->getEstado());
        }
        $result = $this->obtenerHabilitados($alumnoId, $temaId);
        foreach ($result as $concepto) {
            $predecesorasFinalizadas = $this->countPredecesorasFinalizadas($concepto, $alumnoId);
            $cantidadPredecesoras = $concepto->getPredecesoras()->count();
            if ($predecesorasFinalizadas >= $cantidadPredecesoras) {
                return new ResultadoEvaluacion(ResultadoEvaluacion::CURSANDO, $concepto);
            }
        }
        $tema = $this->temaRepository->find($temaId);
        $alumno = $this->alumnoRepository->find($alumnoId);
        $alumnoEstadoTema = new AlumnoEstadoTema($alumno, $tema, true, ResultadoEvaluacion::FINALIZADO);
        $this->alumnoEstadoTemaRepository->crearOActualizar($alumnoEstadoTema);

        return new ResultadoEvaluacion(ResultadoEvaluacion::FINALIZADO);
        
    }
    
    public function proximaActividad($temaId, $alumnoId) {
        $proximoConceptoDisponible = $this->proximoConcepto($temaId, $alumnoId);
        if (ResultadoEvaluacion::CURSANDO != $proximoConceptoDisponible->getEstado()) {
            return new ConceptoProximaActividad($proximoConceptoDisponible, null);
        }
        $proximaActividad = $this->actividadAsignadaService->proximaActividad($proximoConceptoDisponible->getElemento()->getId(), $alumnoId);
        return new ConceptoProximaActividad($proximoConceptoDisponible, $proximaActividad);
    }
    
    private function getAlumnoEstadoConcepto($alumnoId, $conceptoId) {
        $query = $this->alumnoEstadoConceptoRepository->createQueryBuilder('alumnoEstadoConcepto')
                                               ->join('alumnoEstadoConcepto.alumno', 'alu')
                                               ->join('alumnoEstadoConcepto.concepto', 'concepto')
                                               ->where('alu.id = :alumnoId')
                                               ->andWhere('concepto.id = :conceptoId')
                                               ->setParameter('alumnoId', $alumnoId)
                                               ->setParameter('conceptoId', $conceptoId);
               
        return $query->getQuery()->getResult();
    }
    
    protected function countPredecesorasFinalizadas($concepto, $alumnoId) {
        $queryConceptoFinalizado = $this->alumnoEstadoConceptoRepository->createQueryBuilder('alumnoEstadoConcepto')
                                               ->join('alumnoEstadoConcepto.alumno', 'alu') 
                                               ->where('alu.id = :alumnoId')
                                               ->andWhere('alumnoEstadoConcepto.concepto = concepto');
        
        $query = $this->conceptoRepository->createQueryBuilder('concepto');
        
        $query = $query->select('count(concepto.id)')
                       ->leftjoin('concepto.sucesoras', 'sucesora')
                       ->where('sucesora.id = :conceptoId')                       
                       ->andWhere(
                               $query->expr()->orX($query->expr()->exists($queryConceptoFinalizado->getDQL()),
                                                   'concepto.habilitado = false')                               
                               )                       
                       ->setParameter('alumnoId', $alumnoId)
                       ->setParameter('conceptoId', $concepto->getId());
        
        return $query->getQuery()->getSingleScalarResult();
    }
    
    private function obtenerHabilitados($alumnoId, $temaId, $disponible = true, $limit = null, $offset = 0) {
        $queryConceptoFinalizado = $this->createQueryConceptoFinalizado();        
        $query = $this->conceptoRepository->createQueryBuilder('concepto');
        
        $query = $query->join('concepto.tema', 'tema')
                       ->join('tema.curso', 'curso')
                       ->join('curso.alumnos', 'alumno')
                       ->where('tema.id = :temaId')
                       ->andWhere('alumno.id = :alumnoId')
                       ->andWhere('concepto.habilitado = true');
                       if ($disponible) {
                        $query = $query->andWhere($query->expr()->not($query->expr()->exists($queryConceptoFinalizado->getDQL())));                       
                       } else {
                        $query = $query->andWhere($query->expr()->exists($queryConceptoFinalizado->getDQL()));                          
                       }
                       
                       $query->setParameter('temaId', $temaId)
                       ->setParameter('alumnoId', $alumnoId)
                       ->addOrderBy('concepto.orden', 'ASC')
                       ->addOrderBy('concepto.fechaCreacion', 'ASC');
                 
                       if ($limit != null) {
                            $offset = ($offset == null) ? 0 : $offset;
                            $query = $query->setMaxResults($limit)
                                  ->setFirstResult($limit * $offset);
                       }  
        $result = $query->getQuery()->getResult();
        return $result;
    }
    
    private function createQueryConceptoFinalizado() {
            return $this->alumnoEstadoConceptoRepository->createQueryBuilder('alumnoEstadoConcepto')
                                               ->join('alumnoEstadoConcepto.alumno', 'alu') 
                                               ->where('alu.id = :alumnoId')
                                               ->andWhere('alumnoEstadoConcepto.concepto = concepto');
    }

}
