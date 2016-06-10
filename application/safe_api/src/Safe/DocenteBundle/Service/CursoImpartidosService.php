<?php
namespace Safe\AlumnoBundle\Service;

use Safe\CursoBundle\Repository\CursoRepository;

class CursoAsignadoService {
    private $cursoRepository;

    public function __construct(CursoRepository $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }
    
    public function findAll($docenteId, $limit = 5, $offset = 0) {
        $query = $this->cursoRepository->createQueryBuilder('curso')
                                       ->join('curso.docente', 'a')
                                       ->where('a.id = :id')
                                       ->setParameter('id', $alumnoId)
                                       ->getQuery()
                                       ->setMaxResults($limit)
                                       ->setFirstResult($limit * $offset);
        
         return $query->getResult();
    }
    
    public function getById($id) {
        return $this->cursoRepository->find($id);
    }

}
