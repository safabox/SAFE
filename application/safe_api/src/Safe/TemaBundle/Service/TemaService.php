<?php
namespace Safe\TemaBundle\Service;

use Safe\TemaBundle\Repository\TemaRepository;

class TemaService {
    protected $temaRepository;

    public function __construct(TemaRepository $temaRepository)
    {
        $this->temaRepository = $temaRepository;
    }
    
    public function crearOActualizar($tema) {        
        return $this->temaRepository->crearOActualizar($tema);
    }
    
    public function findAll($cursoId, $limit, $offset = 0) {
        return $this->temaRepository->findBy(array('curso' => $cursoId), array('orden' => 'ASC', 'titulo' => 'ASC'), $limit, $offset);
    }
        
    public function getById($id) {
        return $this->temaRepository->find($id);
    }
    
}
