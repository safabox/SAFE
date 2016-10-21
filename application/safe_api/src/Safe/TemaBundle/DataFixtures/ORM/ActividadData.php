<?php
namespace Safe\TemaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\TemaBundle\Entity\Actividad;
use Safe\CatBundle\Entity\Item;
use Doctrine\Common\Util\Debug;
class ActividadData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $actividad1 = new Actividad("Primer actividad");
        $actividad1->setDescripcion("descripcion del primer Actividad");
        $actividad1->setConcepto($this->getReference('curso-matematicas-tema1-concepto1'));
        $actividad1->setHabilitado(true);        
        $actividad1->setEjercicio(array('atributo_1' => 'Esto es un atributo'));
        $manager->persist($actividad1);
        $manager->flush();
    
        $item = new Item();
        $item->setItemBank($this->getReference('itembank-curso-matematicas'));
        $item->setCode($actividad1->getId());   
        $manager->persist($item);

        
        $actividad2 = new Actividad("Segundo actividad sucesora de 1");
        $actividad2->setDescripcion("descripcion del segundo Actividad");
        $actividad2->setConcepto($this->getReference('curso-matematicas-tema1-concepto1'));
        $actividad2->setHabilitado(true);
        $actividad2->setEjercicio(array(
            'atributo_1' => 'Esto es un atributo',
            'atributo_2' => null
        ));
        $manager->persist($actividad2);
        $manager->flush();
        
        $item = new Item();
        $item->setItemBank($this->getReference('itembank-curso-matematicas'));
        $item->setCode($actividad2->getId());
        $manager->persist($item);
        
        $actividad3 = new Actividad("tercer actividad sucesora de 1");
        $actividad3->setDescripcion("descripcion del tercer Actividad");
        $actividad3->setConcepto($this->getReference('curso-matematicas-tema1-concepto1'));
        $actividad3->setHabilitado(true);
        $actividad3->setEjercicio(array('atributo_1' => 'Esto es un atributo'));        
        $manager->persist($actividad3);
        $manager->flush();
        
        $item = new Item();
        $item->setItemBank($this->getReference('itembank-curso-matematicas'));
        $item->setCode($actividad3->getId());
        $manager->persist($item);
        
        $actividad4 = new Actividad("4 actividad sucesora de 1");
        $actividad4->setDescripcion("descripcion del 4 Actividad");
        $actividad4->setConcepto($this->getReference('curso-matematicas-tema1-concepto1'));
        $actividad4->setHabilitado(true);
        $actividad4->setEjercicio(array('atributo_1' => 'Esto es un atributo'));
        $manager->persist($actividad4);
        $manager->flush();
        
        $item = new Item();
        $item->setItemBank($this->getReference('itembank-curso-matematicas'));
        $item->setCode($actividad4->getId());
        $manager->persist($item);   
        
        $actividad5 = new Actividad("5 actividad");
        $actividad5->setDescripcion("descripcion del 5 Actividad");
        $actividad5->setConcepto($this->getReference('curso-matematicas-tema1-concepto1'));
        $actividad5->setHabilitado(true);
        $actividad5->setEjercicio(array('atributo_1' => 'Esto es un atributo'));
        $manager->persist($actividad5);
        $manager->flush();
        
        $item = new Item();
        $item->setItemBank($this->getReference('itembank-curso-matematicas'));
        $item->setCode($actividad5->getId());
        $manager->persist($item);
        $manager->flush();

        $this->addReference('curso-matematicas-tema1-concepto1-actividad1', $actividad1);
        $this->addReference('curso-matematicas-tema1-concepto1-actividad2', $actividad2);
        $this->addReference('curso-matematicas-tema1-concepto1-actividad3', $actividad3);
        $this->addReference('curso-matematicas-tema1-concepto1-actividad4', $actividad4);
        $this->addReference('curso-matematicas-tema1-concepto1-actividad5', $actividad5);
        
    }

    public function getOrder() {
        return 10;
    }

}
