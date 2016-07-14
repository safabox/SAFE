<?php
namespace Safe\PerfilBundle\Service;

use Safe\PerfilBundle\Repository\UsuarioRepository;

class UsuarioService {
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }
    
    public function findAll($limit = 10, $offset = 0) {
         return $this->usuarioRepository->findBy(array(), null, $limit, $offset);
    }
    
    public function getById($id) {
        return $this->usuarioRepository->find($id);
    }

    public function save($usuario) {
        return $this->usuarioRepository->save($usuario);              
    }
}
