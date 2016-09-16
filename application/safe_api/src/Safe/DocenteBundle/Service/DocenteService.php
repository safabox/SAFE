<?php
namespace Safe\DocenteBundle\Service;

use Safe\DocenteBundle\Repository\DocenteRepository;

class DocenteService {
    private $docenteRepository;

    public function __construct(DocenteRepository $docenteRepository)
    {
        $this->docenteRepository = $docenteRepository;
    }
    
    public function findAll($limit = null, $offset = null) {
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
    
    public function cantidadDocentes($instituto) {
        $query = $this->docenteRepository->createQueryBuilder('docente2');
        $query->select($query->expr()->count('docente.id'));
        $query->from('SafeDocenteBundle:Docente','docente')
                ->join('docente.instituto', 'i')
                ->where('i.id = :id')
                ->setParameter('id', $instituto->getId());
        $count = $query->getQuery()->getSingleScalarResult();
        return $count;        
    }
}
