<?php
namespace Safe\DocenteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Safe\PerfilBundle\DataFixtures\ORM\PerfilDataAbstract;
use Safe\DocenteBundle\Entity\Docente;

class DocenteData extends PerfilDataAbstract
{
    
    public function crearDocente($username='docente', $legajo='0', $curriculum='Experto') {
        $docente = new Docente();
        $docente->setId($legajo);
        $docente->setCurriculum($curriculum);
        $docente->setLegajo($legajo);
        $docente->setUsuario($this->crearUsuario($username, '123456', array('ROLE_DOCENTE')));
        $docente->setInstituto($this->getReference('instituto'));
        return $docente;
                
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {        

        $docente = $this->crearDocente('docente1', '1');
        $manager->persist($docente->getUsuario());
        $manager->persist($docente);
        $manager->flush();
        $this->addReference('docente1', $docente);

        $docente = $this->crearDocente('docente2', '2');
        $manager->persist($docente->getUsuario());
        $manager->persist($docente);
        $manager->flush();
        $this->addReference('docente2', $docente);
        
        
        $docente = $this->crearDocente('docente3', '3');
        $manager->persist($docente->getUsuario());
        $manager->persist($docente);
        $manager->flush();
        $this->addReference('docente3', $docente);
    }

    public function getOrder() {
        return 4;
    }

}
