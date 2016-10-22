<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\TemaRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoTemaRepository;

use Safe\TemaBundle\Service\TemaService;
use Doctrine\Common\Util\Debug;
class TemaAsignadoService extends TemaService {

    private $alumnoEstadoTemaRepository;
    
    public function __construct(TemaRepository $temaRepository, AlumnoEstadoTemaRepository $alumnoEstadoTemaRepository)
    {
        parent::__construct($temaRepository);
        $this->alumnoEstadoTemaRepository = $alumnoEstadoTemaRepository;
    }
    
    public function proximoTema($cursoId, $alumnoId) {
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
                return $tema;
            }
        }
        return null;
        
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
