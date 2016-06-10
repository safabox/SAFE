<?php
namespace Safe\AlumnoBundle\Service;

use Safe\AlumnoBundle\Repository\AlumnoRepository;

class AlumnoService {
    private $alumnoRepository;

    public function __construct(AlumnoRepository $alumnoRepository)
    {
        $this->alumnoRepository = $alumnoRepository;
    }
    
    public function findAll($limit = 5, $offset = 0) {
         return $this->alumnoRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getById($id) {
        return $this->alumnoRepository->find($id);
    }

}
