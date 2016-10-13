<?php
namespace Safe\DocenteBundle\Service;

use Safe\TemaBundle\Repository\TemaRepository;

class TemaImpartidoService {
    private $temaRepository;

    public function __construct(TemaRepository $temaRepository)
    {
        $this->temaRepository = $temaRepository;
    }
    
    public function findAll($cursoId, $limit = 10, $offset = 0) {
        return $this->temaRepository->findBy(array('curso' => $cursoId), null, $limit, $offset);
    }
        
    public function getById($id) {
        return $this->temaRepository->find($id);
    }

}
