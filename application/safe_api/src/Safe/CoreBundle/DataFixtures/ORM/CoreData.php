<?php
namespace Safe\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\PerfilBundle\Entity\Usuario;
use Safe\PerfilBundle\Entity\TipoDocumento;

class CoreData extends AbstractFixture implements OrderedFixtureInterface
{

    static public $tipoDocumentos = array();
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $tipoDocumento = new TipoDocumento();
        $tipoDocumento->setId(1);
        $tipoDocumento->setCodigo('DNI');
        $tipoDocumento->setDescripcion('Documento Nacional');
        
        $manager->persist($tipoDocumento);

        $manager->flush();
        
        $this->addReference('DNI', $tipoDocumento);
        self::$tipoDocumentos = array($tipoDocumento);
    }

    public function getOrder() {
        return 1;
    }

}
