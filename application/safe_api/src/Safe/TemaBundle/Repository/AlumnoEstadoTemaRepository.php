<?php

namespace Safe\TemaBundle\Repository;

/**
 * AlumnoEstadoTemaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlumnoEstadoTemaRepository extends \Doctrine\ORM\EntityRepository
{
    public function crearOActualizar($alumnoEstadoTema) {
        $em = $this->getEntityManager();
        $em->persist($alumnoEstadoTema);                 
        $em->flush();   
        return $alumnoEstadoTema;
    }
}
