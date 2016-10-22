<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\ConceptoRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoConceptoRepository;

use Safe\TemaBundle\Service\ConceptoService;
use Doctrine\Common\Util\Debug;
class ConceptoAsignadoService extends ConceptoService {

    private $alumnoEstadoConceptoRepository;
    
    public function __construct(ConceptoRepository $conceptoRepository, AlumnoEstadoConceptoRepository $alumnoEstadoConceptoRepository)
    {
        parent::__construct($conceptoRepository);
        $this->alumnoEstadoConceptoRepository = $alumnoEstadoConceptoRepository;
    }
    
    public function proximoConcepto($temaId, $alumnoId) {
        $queryConceptoFinalizado = $this->alumnoEstadoConceptoRepository->createQueryBuilder('alumnoEstadoConcepto')
                                                       ->join('alumnoEstadoConcepto.alumno', 'alu') 
                                                       ->where('alu.id = :alumnoId')
                                                       ->andWhere('alumnoEstadoConcepto.concepto = concepto')
                                                       
                                                       ;
        
        $query = $this->conceptoRepository->createQueryBuilder('concepto');
        
        $query = $query->join('concepto.tema', 'tema')
                       ->join('tema.curso', 'curso')
                       ->join('curso.alumnos', 'alumno')
                       ->where('tema.id = :temaId')
                       ->andWhere('alumno.id = :alumnoId')
                       ->andWhere('concepto.habilitado = true')
                       ->andWhere($query->expr()->not($query->expr()->exists($queryConceptoFinalizado->getDQL())))                       
                       ->setParameter('temaId', $temaId)
                       ->setParameter('alumnoId', $alumnoId)
                       ->addOrderBy('concepto.orden', 'ASC')
                       ->addOrderBy('concepto.fechaCreacion', 'ASC')
                 ;
        $result = $query->getQuery()->getResult();
        foreach ($result as $concepto) {
            $predecesorasFinalizadas = $this->countPredecesorasFinalizadas($concepto, $alumnoId);
            $cantidadPredecesoras = $concepto->getPredecesoras()->count();
            if ($predecesorasFinalizadas >= $cantidadPredecesoras) {
                return $concepto;
            }
        }
        return null;
        
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

}
