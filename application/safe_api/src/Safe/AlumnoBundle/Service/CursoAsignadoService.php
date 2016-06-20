<?php
namespace Safe\AlumnoBundle\Service;

use Safe\CursoBundle\Repository\CursoRepository;

class CursoAsignadoService {
    private $cursoRepository;

    public function __construct(CursoRepository $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }
    
    public function findAll($alumnoId, $limit = 10, $offset = 0) {
        $query = $this->cursoRepository->createQueryBuilder('curso')
                                       ->join('curso.alumnos', 'a')
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
