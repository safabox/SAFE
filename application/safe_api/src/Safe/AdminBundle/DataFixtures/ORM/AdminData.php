<?php
namespace Safe\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\CoreBundle\DataFixtures\ORM\CoreData;
use Safe\PerfilBundle\Entity\Usuario;
use Safe\PerfilBundle\Entity\TipoDocumento;
use Safe\PerfilBundle\DataFixtures\ORM\PerfilDataAbstract;


class AdminData extends PerfilDataAbstract
{
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {        
      
        $usuario = $this->crearUsuario('admin', '123456', array('ROLE_ADMIN'));

        $manager->persist($usuario);

        $manager->flush();

        $this->addReference('usuario-admin', $usuario);
    }

    public function getOrder() {
        return 3;
    }

}
