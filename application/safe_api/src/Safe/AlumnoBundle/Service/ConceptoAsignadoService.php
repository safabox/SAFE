<?php
namespace Safe\AlumnoBundle\Service;

use Safe\TemaBundle\Repository\ConceptoRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoConceptoRepository;
use Safe\TemaBundle\Repository\AlumnoEstadoTemaRepository;
use Safe\AlumnoBundle\Repository\AlumnoRepository;
use Safe\TemaBundle\Repository\TemaRepository;

use Safe\TemaBundle\Service\ConceptoService;

use Safe\AlumnoBundle\Entity\ProximoResultado;
use Safe\TemaBundle\Entity\AlumnoEstadoTema;
use Doctrine\Common\Util\Debug;
class ConceptoAsignadoService extends ConceptoService {

    private $alumnoRepository;
    
    private $temaRepository;
    
    private $alumnoEstadoConceptoRepository;
    
    private $alumnoEstadoTemaRepository;
    
    public function __construct(ConceptoRepository $conceptoRepository,
            AlumnoRepository $alumnoRepository, TemaRepository $temaRepository, 
            AlumnoEstadoConceptoRepository $alumnoEstadoConceptoRepository,
            AlumnoEstadoTemaRepository $alumnoEstadoTemaRepository
            )
    {
        parent::__construct($conceptoRepository);
        $this->alumnoEstadoConceptoRepository = $alumnoEstadoConceptoRepository;
        $this->alumnoRepository = $alumnoRepository;
        $this->temaRepository = $temaRepository;
        $this->alumnoEstadoTemaRepository = $alumnoEstadoTemaRepository;
    }
    
    public function proximoConcepto($temaId, $alumnoId) {
        
        $alumnoEstadoTema = $this->alumnoEstadoTemaRepository->findOneBy(array('tema'=> $temaId, 'alumno' => $alumnoId));
        if ($alumnoEstadoTema != null) {
            return new ProximoResultado($alumnoEstadoTema->getEstado());
        }
        
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
                return new ProximoResultado(ProximoResultado::CURSANDO, $concepto);
            }
        }
        $tema = $this->temaRepository->find($temaId);
        $alumno = $this->alumnoRepository->find($alumnoId);
        $alumnoEstadoTema = new AlumnoEstadoTema($alumno, $tema, true, ProximoResultado::FINALIZADO);
        $this->alumnoEstadoTemaRepository->crearOActualizar($alumnoEstadoTema);

        return new ProximoResultado(ProximoResultado::FINALIZADO);
        
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
