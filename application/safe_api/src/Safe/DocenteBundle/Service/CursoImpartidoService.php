<?php
namespace Safe\DocenteBundle\Service;

use Safe\CursoBundle\Repository\CursoRepository;
use Safe\CursoBundle\Service\CursoService;
use Doctrine\ORM\EntityManager;
class CursoImpartidoService extends CursoService {

    private $entityManager;
    
    public function __construct(EntityManager $entityManager, CursoRepository $cursoRepository)
    {
        parent::__construct($cursoRepository);
        $this->entityManager = $entityManager;
    }
    
    
    public function findAllByDocente($docenteId, $limit, $offset) {
        //return $this->cursoRepository->findBy(array('docente' => $docenteId), null, $limit, $offset);
        
        $query = $this->cursoRepository->createQueryBuilder('curso')
                                       ->join('curso.docentes', 'd')
                                       ->where('d.id = :id')
                                       ->setParameter('id', $docenteId)
                                       ->getQuery();
        if ($limit != null) {
            $offset = ($offset == null) ? 0 : $offset;
            $query->setMaxResults($limit)
                  ->setFirstResult($limit * $offset);
        }
        foreach ($query->getResult() as $curso) {
            $alumnosFinalizados = $this->countAlumnosFinalizados($curso);
            $curso->setCantAlumnosFinalizados($alumnosFinalizados);
        }
        return $query->getResult();
    }
    
    private function countAlumnosFinalizados($curso) {
         $query = $this->cursoRepository->createQueryBuilder('curso')
                 ->select('count(curso.id)')
                 ->join('curso.estadosAlumnos', 'estados')
                 ->where('estados.aprobado = true')
                 ->andWhere('curso.id = :idCurso') 
                 ->setParameter('idCurso', $curso->getId()) 
                 ->getQuery();
       
         return $query->getSingleScalarResult();
    }
}
