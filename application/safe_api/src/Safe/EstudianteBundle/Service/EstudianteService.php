<?php
namespace Safe\EstudianteBundle\Service;

use Safe\EstudianteBundle\Repository\EstudianteRepository;

class EstudianteService {
    private $estudianteRepository;

    public function __construct(EstudianteRepository $estudianteRepository)
    {
        $this->estudianteRepository = $estudianteRepository;
    }
    
    public function findAll($limit = 5, $offset = 0) {
         return $this->estudianteRepository->findBy(array(), null, $limit, $offset);
    }

}
