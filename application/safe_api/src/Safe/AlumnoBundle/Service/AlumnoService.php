<?php
namespace Safe\AlumnoBundle\Service;

use Safe\AlumnoBundle\Repository\AlumnoRepository;

class AlumnoService {
    private $alumnoRepository;

    public function __construct(AlumnoRepository $alumnoRepository)
    {
        $this->alumnoRepository = $alumnoRepository;
    }
    
    public function findAll($limit = 10, $offset = 0) {
         return $this->alumnoRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getById($id) {
        return $this->alumnoRepository->find($id);
    }
    
    public function crearOActualizar($alumno) {
        $alumno->setRol();
        return $this->alumnoRepository->crearOActualizar($alumno);
    }
    
    public function buscarPorCursos($cursoId, $limit = 10, $offset = 0) {
        $query = $this->alumnoRepository->createQueryBuilder('alumno')
                                       ->join('alumno.cursos', 'c')
                                       ->where('c.id = :id')
                                       ->setParameter('id', $cursoId)
                                       ->getQuery()
                                       ->setMaxResults($limit)
                                       ->setFirstResult($limit * $offset);
        
         return $query->getResult();
    }

}
