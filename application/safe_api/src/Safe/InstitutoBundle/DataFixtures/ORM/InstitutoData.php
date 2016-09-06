<?php
namespace Safe\InstitutoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\InstitutoBundle\Entity\Instituto;

class InstitutoData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $institutos = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $instituto = new Instituto();
        $instituto->setRazonSocial("Instituto Test");
        $instituto->setDescripcion("descripcion test");
        

        $manager->persist($instituto);

        $manager->flush();

        $this->addReference('instituto', $instituto);

        self::$institutos = array($instituto);
    }

    public function getOrder() {
        return 2;
    }

}
