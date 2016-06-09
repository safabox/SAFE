<?php
namespace Safe\DocenteBundle\Service;

use Safe\DocenteBundle\Repository\DocenteRepository;

class DocenteService {
    private $docenteRepository;

    public function __construct(DocenteRepository $docenteRepository)
    {
        $this->docenteRepository = $docenteRepository;
    }
    
    public function findAll($limit = 5, $offset = 0) {
         return $this->docenteRepository->findBy(array(), null, $limit, $offset);
    }

}
