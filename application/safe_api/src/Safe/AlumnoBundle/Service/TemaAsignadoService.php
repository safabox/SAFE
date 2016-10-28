<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\TemaRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoTemaRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoCursoRepository;

use Safe\AlumnoBundle\Repository\AlumnoRepository;
use Safe\CursoBundle\Repository\CursoRepository;
use Safe\TemaBundle\Entity\AlumnoEstadoCurso;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;

use Safe\TemaBundle\Service\TemaService;
use Safe\AlumnoBundle\Entity\TemasAsignados;
use Safe\AlumnoBundle\Entity\TemaFinalizado;
use Safe\AlumnoBundle\Entity\TemaProximaActividad;
use Safe\AlumnoBundle\Service\ConceptoAsignadoService;

use Doctrine\Common\Util\Debug;
class TemaAsignadoService extends TemaService {

    private $alumnoEstadoTemaRepository;
    
    private $alumnoRepository;
    
    private $cursoRepository;
    
    private $alumnoEstadoCursoRepository;
    
    private $conceptoAsignadoService;
    
    public function __construct(TemaRepository $temaRepository, 
            AlumnoRepository $alumnoRepository,
            CursoRepository $cursoRepository,
            AlumnoEstadoTemaRepository $alumnoEstadoTemaRepository,
            AlumnoEstadoCursoRepository $alumnoEstadoCursoRepository,
            ConceptoAsignadoService $conceptoAsignadoService
            )
    {
        parent::__construct($temaRepository);
        $this->alumnoEstadoTemaRepository = $alumnoEstadoTemaRepository;
        $this->alumnoRepository = $alumnoRepository;
        $this->cursoRepository = $cursoRepository;
        $this->alumnoEstadoCursoRepository = $alumnoEstadoCursoRepository;
        $this->conceptoAsignadoService = $conceptoAsignadoService;
        
    }
    
    public function findAll($alumnoId, $cursoId, $limit = null, $offset = 0) {
        $result = $this->obtenerHabilitados($alumnoId, $cursoId, true, $limit, $offset);
        $finalizados = $this->obtenerHabilitados($alumnoId, $cursoId, false, $limit, $offset);
        $disponibles = array();
        $bloqueados = array();
        
        foreach ($result as $tema) {
            $predecesorasFinalizadas = $this->countPredecesorasFinalizadas($tema, $alumnoId);
            $cantidadPredecesoras = $tema->getPredecesoras()->count();
            if ($predecesorasFinalizadas >= $cantidadPredecesoras) {
                $disponibles[] = $tema;
            } else {
                $bloqueados[] = $tema;
            }
        }
        $finalizadosConEstados = array();
        foreach($finalizados as $finalizado) {
            $estados = $this->getAlumnoEstadoTema($alumnoId, $finalizado->getId());
            if (count($estados) > 0) {
                $estado = $estados[0]->getEstado();
            } else {
                $estado = ResultadoEvaluacion::FINALIZADO;
            }
            $finalizadosConEstados[] = new TemaFinalizado($tema, $estado);
        }
        
        return new TemasAsignados($disponibles, $bloqueados, $finalizadosConEstados);
    }
    
    public function proximoTema($cursoId, $alumnoId) {
        $alumnoEstadoCurso = $this->alumnoEstadoCursoRepository->findOneBy(array('curso'=> $cursoId, 'alumno' => $alumnoId));
        if ($alumnoEstadoCurso != null) {
            return new ResultadoEvaluacion($alumnoEstadoCurso->getEstado());
        }        
        $result = $this->obtenerHabilitados($alumnoId, $cursoId);
        foreach ($result as $tema) {
            $predecesorasFinalizadas = $this->countPredecesorasFinalizadas($tema, $alumnoId);
            $cantidadPredecesoras = $tema->getPredecesoras()->count();
            if ($predecesorasFinalizadas >= $cantidadPredecesoras) {
                return new ResultadoEvaluacion(ResultadoEvaluacion::CURSANDO, $tema);
            }
        }
        
        $curso = $this->cursoRepository->find($cursoId);
        $alumno = $this->alumnoRepository->find($alumnoId);
        $alumnoEstadoCurso = new AlumnoEstadoCurso($alumno, $curso, true, ResultadoEvaluacion::FINALIZADO);
        $this->alumnoEstadoCursoRepository->crearOActualizar($alumnoEstadoCurso);

        return new ResultadoEvaluacion(ResultadoEvaluacion::FINALIZADO);
        
    }
    
    public function proximaActividad($cursoId, $alumnoId) {
        $proximoTemaDisponible = $this->proximoTema($cursoId, $alumnoId);
        if (ResultadoEvaluacion::CURSANDO != $proximoTemaDisponible->getEstado()) {
            return new TemaProximaActividad($proximoTemaDisponible, null, null);
        }
        $temaId = $proximoTemaDisponible->getElemento()->getId();
        $proximoConceptoActividad = $this->conceptoAsignadoService->proximaActividad($temaId, $alumnoId);
        return new TemaProximaActividad($proximoTemaDisponible, $proximoConceptoActividad->getConcepto(), $proximoConceptoActividad->getActividad());
    }
    
    private function getAlumnoEstadoTema($alumnoId, $temaId) {
        $query = $this->alumnoEstadoTemaRepository->createQueryBuilder('alumnoEstadoTema')
                                               ->join('alumnoEstadoTema.alumno', 'alu')
                                               ->join('alumnoEstadoTema.tema', 'tema')
                                               ->where('alu.id = :alumnoId')
                                               ->andWhere('tema.id = :temaId')
                                               ->setParameter('alumnoId', $alumnoId)
                                               ->setParameter('temaId', $temaId);
               
        return $query->getQuery()->getResult();
    }
        
    private function countPredecesorasFinalizadas($tema, $alumnoId) {
        $queryTemaFinalizado = $this->createQueryTemaFinalizado();
        
        $query = $this->temaRepository->createQueryBuilder('tema');
        
        $query = $query->select('count(tema.id)')
                       ->leftjoin('tema.sucesoras', 'sucesora')
                       ->where('sucesora.id = :temaId')                       
                       ->andWhere(
                               $query->expr()->orX($query->expr()->exists($queryTemaFinalizado->getDQL()),
                                                   'tema.habilitado = false')                               
                               )                       
                       ->setParameter('alumnoId', $alumnoId)
                       ->setParameter('temaId', $tema->getId());
        
        return $query->getQuery()->getSingleScalarResult();
    }
    
    private function obtenerHabilitados($alumnoId, $cursoId, $disponible = true, $limit = null, $offset = 0) {
        $queryTemaFinalizado = $this->createQueryTemaFinalizado();
        $query = $this->temaRepository->createQueryBuilder('tema');
        
        $query = $query->join('tema.curso', 'curso')                                       
                       ->join('curso.alumnos', 'alumno')
                       //->leftjoin('tema.predecesoras', 'predecesora')
                       ->where('curso.id = :cursoId')
                       ->andWhere('alumno.id = :alumnoId')
                       ->andWhere('tema.habilitado = true');
                       if ($disponible) {
                        $query = $query->andWhere($query->expr()->not($query->expr()->exists($queryTemaFinalizado->getDQL())));                          
                       } else {
                        $query = $query->andWhere($query->expr()->exists($queryTemaFinalizado->getDQL()));                          
                       }
                       
        $query = $query->setParameter('cursoId', $cursoId)
                       ->setParameter('alumnoId', $alumnoId)
                       ->addOrderBy('tema.orden', 'ASC')
                       ->addOrderBy('tema.fechaCreacion', 'ASC');
                      if ($limit != null) {
                            $offset = ($offset == null) ? 0 : $offset;
                            $query = $query->setMaxResults($limit)
                                  ->setFirstResult($limit * $offset);
                       }   
        
        $result = $query->getQuery()->getResult();
        return $result;
    }
    private function createQueryTemaFinalizado() {
            return $this->alumnoEstadoTemaRepository->createQueryBuilder('alumnoEstadoTema')
                                               ->join('alumnoEstadoTema.alumno', 'alu') 
                                               ->where('alu.id = :alumnoId')
                                               ->andWhere('alumnoEstadoTema.tema = tema');

    }


}
