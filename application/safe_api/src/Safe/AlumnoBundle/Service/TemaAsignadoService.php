<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\TemaRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoTemaRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoCursoRepository;

use Safe\AlumnoBundle\Repository\AlumnoRepository;
use Safe\CursoBundle\Repository\CursoRepository;
use Safe\TemaBundle\Entity\AlumnoEstadoCurso;
use Safe\AlumnoBundle\Entity\ProximoResultado;

use Safe\TemaBundle\Service\TemaService;
use Doctrine\Common\Util\Debug;
class TemaAsignadoService extends TemaService {

    private $alumnoEstadoTemaRepository;
    
    private $alumnoRepository;
    
    private $cursoRepository;
    
    private $alumnoEstadoCursoRepository;
    
    public function __construct(TemaRepository $temaRepository, 
            AlumnoRepository $alumnoRepository,
            CursoRepository $cursoRepository,
            AlumnoEstadoTemaRepository $alumnoEstadoTemaRepository,
            AlumnoEstadoCursoRepository $alumnoEstadoCursoRepository)
    {
        parent::__construct($temaRepository);
        $this->alumnoEstadoTemaRepository = $alumnoEstadoTemaRepository;
        $this->alumnoRepository = $alumnoRepository;
        $this->cursoRepository = $cursoRepository;
        $this->alumnoEstadoCursoRepository = $alumnoEstadoCursoRepository;
        
    }
    
    public function proximoTema($cursoId, $alumnoId) {
        $alumnoEstadoCurso = $this->alumnoEstadoCursoRepository->findOneBy(array('curso'=> $cursoId, 'alumno' => $alumnoId));
        if ($alumnoEstadoCurso != null) {
            return new ProximoResultado($alumnoEstadoCurso->getEstado());
        }
        
        $queryTemaFinalizado = $this->alumnoEstadoTemaRepository->createQueryBuilder('alumnoEstadoTema')
                                                       ->join('alumnoEstadoTema.alumno', 'alu') 
                                                       ->where('alu.id = :alumnoId')
                                                       ->andWhere('alumnoEstadoTema.tema = tema')
                                                       
                                                       ;
        
        $query = $this->temaRepository->createQueryBuilder('tema');
        
        $query = $query->join('tema.curso', 'curso')                                       
                       ->join('curso.alumnos', 'alumno')
                       //->leftjoin('tema.predecesoras', 'predecesora')
                       ->where('curso.id = :cursoId')
                       ->andWhere('alumno.id = :alumnoId')
                       ->andWhere('tema.habilitado = true')
                       ->andWhere($query->expr()->not($query->expr()->exists($queryTemaFinalizado->getDQL())))                       
                       ->setParameter('cursoId', $cursoId)
                       ->setParameter('alumnoId', $alumnoId)
                       ->addOrderBy('tema.orden', 'ASC')
                       ->addOrderBy('tema.fechaCreacion', 'ASC')
                 ;
        $result = $query->getQuery()->getResult();
        foreach ($result as $tema) {
            $predecesorasFinalizadas = $this->countPredecesorasFinalizadas($tema, $alumnoId);
            $cantidadPredecesoras = $tema->getPredecesoras()->count();
            if ($predecesorasFinalizadas >= $cantidadPredecesoras) {
                return new ProximoResultado(ProximoResultado::CURSANDO, $tema);
            }
        }
        
        $curso = $this->cursoRepository->find($cursoId);
        $alumno = $this->alumnoRepository->find($alumnoId);
        $alumnoEstadoCurso = new AlumnoEstadoCurso($alumno, $curso, true, ProximoResultado::FINALIZADO);
        $this->alumnoEstadoCursoRepository->crearOActualizar($alumnoEstadoCurso);

        return new ProximoResultado(ProximoResultado::FINALIZADO);
        
    }
    
    protected function countPredecesorasFinalizadas($tema, $alumnoId) {
        $queryTemaFinalizado = $this->alumnoEstadoTemaRepository->createQueryBuilder('alumnoEstadoTema')
                                               ->join('alumnoEstadoTema.alumno', 'alu') 
                                               ->where('alu.id = :alumnoId')
                                               ->andWhere('alumnoEstadoTema.tema = tema');
        
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

}
