<?php
namespace Safe\TemaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\TemaBundle\Entity\Tema;

class TemaData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $tema1 = new Tema();
        $tema1->setTitulo("Primer tema");
        $tema1->setDescripcion("descripcion del primer Tema");
        $tema1->setCurso($this->getReference('curso-matematicas'));
        $tema1->setOrden(1);
        $tema1->setHabilitado(true);
        $manager->persist($tema1);

        $tema2 = new Tema();
        $tema2->setTitulo("Segundo tema sucesora de 1");
        $tema2->setDescripcion("descripcion del segundo Tema");
        $tema2->setCurso($this->getReference('curso-matematicas'));
        $tema2->getPredecesoras()->add($tema1);
        $tema2->setOrden(1);
        $tema2->setHabilitado(true);
        $manager->persist($tema2);
        
        $tema3 = new Tema();
        $tema3->setTitulo("tercer tema sucesora de 1");
        $tema3->setDescripcion("descripcion del tercer Tema");
        $tema3->setCurso($this->getReference('curso-matematicas'));
        $tema3->getPredecesoras()->add($tema1);
        $tema3->setOrden(1);
        $tema3->setHabilitado(true);
        $manager->persist($tema3);

        
        $tema4 = new Tema();
        $tema4->setTitulo("4 tema sucesora de 1");
        $tema4->setDescripcion("descripcion del 4 Tema");
        $tema4->setCurso($this->getReference('curso-matematicas'));
        $tema4->getPredecesoras()->add($tema2);
        $tema4->getPredecesoras()->add($tema3);
        $tema4->setOrden(1);
        $tema4->setHabilitado(true);
        $manager->persist($tema4);
        
        $tema5 = new Tema();
        $tema5->setTitulo("5 tema");
        $tema5->setDescripcion("descripcion del 5 Tema");
        $tema5->setCurso($this->getReference('curso-matematicas'));
        $tema5->setOrden(1);
        $tema5->setHabilitado(true);
        $manager->persist($tema5);

        $manager->flush();

        $this->addReference('curso-matematicas-tema1', $tema1);
        $this->addReference('curso-matematicas-tema2', $tema2);
        $this->addReference('curso-matematicas-tema3', $tema3);
        $this->addReference('curso-matematicas-tema4', $tema4);
        $this->addReference('curso-matematicas-tema5', $tema5);
        
    }

    public function getOrder() {
        return 7;
    }

}
