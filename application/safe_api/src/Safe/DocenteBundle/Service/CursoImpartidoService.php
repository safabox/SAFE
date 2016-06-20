<?php
namespace Safe\DocenteBundle\Service;

use Safe\CursoBundle\Repository\CursoRepository;

class CursoImpartidoService {
    private $cursoRepository;

    public function __construct(CursoRepository $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }
    
    public function findAll($docenteId, $limit = 10, $offset = 0) {
        return $this->cursoRepository->findBy(array('docente' => $docenteId), null, $limit, $offset);
        
        /*$query = $this->cursoRepository->createQueryBuilder('curso')
                                       ->join('curso.docente', 'd')
                                       ->where('d.id = :id')
                                       ->setParameter('id', $docenteId)
                                       ->getQuery()
                                       ->setMaxResults($limit)
                                       ->setFirstResult($limit * $offset);
        
         return $query->getResult();*/
    }
        
    public function getById($id) {
        return $this->cursoRepository->find($id);
    }

}
