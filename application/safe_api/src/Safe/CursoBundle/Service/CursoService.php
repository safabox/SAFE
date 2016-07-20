<?php
namespace Safe\CursoBundle\Service;

use Safe\CursoBundle\Repository\CursoRepository;

class CursoService {
    private $cursoRepository;

    public function __construct(CursoRepository $cursoRepository)
    {
        $this->cursoRepository = $cursoRepository;
    }
    
    public function findAll($limit = 10, $offset = 0) {
         return $this->cursoRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getById($id) {
        return $this->cursoRepository->find($id);
    }
    
    public function crearOActualizar($curso) {        
        return $this->cursoRepository->crearOActualizar($curso);
    }

}
