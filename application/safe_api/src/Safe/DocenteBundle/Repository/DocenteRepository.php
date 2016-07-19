<?php

namespace Safe\DocenteBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DocenteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DocenteRepository extends EntityRepository
{
    
    public function crearOActualizar($docente) {
        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();
        
        try {
            $em->persist($docente->getUsuario());
            $em->persist($docente);            
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();            
            throw $ex;
        }
    }
}
