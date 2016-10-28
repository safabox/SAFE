<?php
namespace Safe\CoreBundle\Service;

abstract class SafeCRUDAbstractService {
    
    public function findAll($limit = 10, $offset = 0) {
         return $this->getRepository()->findBy(array(), null, $limit, $offset);
    }
    
    public function getById($id) {
        return $this->getRepository()->find($id);
    }
    
    public function crearOActualizar($entidad) {        
        return $this->getRepository()->crearOActualizar($entidad);
    }
    
    protected abstract function getRepository();
}
