<?php
namespace Safe\AlumnoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Safe\PerfilBundle\DataFixtures\ORM\PerfilDataAbstract;
use Safe\AlumnoBundle\Entity\Alumno;

use Doctrine\Common\Util\Debug;
class AlumnoData extends PerfilDataAbstract
{
    
    public function crearAlumno($username='alumno', $legajo='0') {
        $alumno = new Alumno();
        $alumno->setId($legajo);
        $alumno->setLegajo($legajo);
        $alumno->setUsuario($this->crearUsuario($username, '123456', array('ROLE_ALUMNO')));
        $alumno->setInstituto($this->getReference('instituto'));        
        return $alumno;
                
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {        

        $alumno = $this->crearAlumno('alumno1', '1');
        $manager->persist($alumno->getUsuario());
        $manager->persist($alumno);                
        $manager->flush();
        $this->addReference('alumno1', $alumno);

        $alumno = $this->crearAlumno('alumno2', '2');
        $manager->persist($alumno->getUsuario());
        $manager->persist($alumno);
        $manager->flush();
        $this->addReference('alumno2', $alumno);
        
        
        $alumno = $this->crearAlumno('alumno3', '3');
        $manager->persist($alumno->getUsuario());
        $manager->persist($alumno);
        $manager->flush();
        $this->addReference('alumno3', $alumno);
    }

    public function getOrder() {
        return 5;
    }

}
