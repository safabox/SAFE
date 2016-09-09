<?php
namespace Safe\DocenteBundle\Service;

use Safe\DocenteBundle\Repository\DocenteRepository;

class DocenteService {
    private $docenteRepository;

    public function __construct(DocenteRepository $docenteRepository)
    {
        $this->docenteRepository = $docenteRepository;
    }
    
    public function findAll($limit = 10, $offset = 0) {
         return $this->docenteRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getById($id) {
        return $this->docenteRepository->find($id);
    }

    public function crearOActualizar($docente) {
        $docente->setRol();
        return $this->docenteRepository->crearOActualizar($docente);
    }
    
    public function buscarPorUsuario($usuario) {
        $query = $this->docenteRepository->createQueryBuilder('docente')
                                       ->join('docente.usuario', 'u')
                                       ->where('u.id = :id')
                                       ->setParameter('id', $usuario->getId())
                                       ->getQuery();
        
         return $query->getOneOrNullResult();
    }
}
