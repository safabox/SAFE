<?php
namespace Safe\TemaBundle\Service;

use Safe\TemaBundle\Repository\TemaRepository;

class TemaService {
    private $temaRepository;

    public function __construct(TemaRepository $temaRepository)
    {
        $this->temaRepository = $temaRepository;
    }
    
    public function crearOActualizar($tema) {        
        return $this->temaRepository->crearOActualizar($tema);
    }
    
    

}
