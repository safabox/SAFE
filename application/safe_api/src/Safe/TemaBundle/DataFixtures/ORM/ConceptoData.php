<?php
namespace Safe\TemaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\TemaBundle\Entity\Concepto;
use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\ItemType;
use Safe\CatBundle\Entity\ThetaEstimationMethodType;
class ConceptoData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $concepto1 = new Concepto();
        $concepto1->setTitulo("Primer concepto");
        $concepto1->setDescripcion("descripcion del primer Concepto");
        $concepto1->setTema($this->getReference('curso-matematicas-tema1'));
        $concepto1->setOrden(1);
        $concepto1->setHabilitado(true);
        $manager->persist($concepto1);
        $manager->flush();

        $itemBank = new ItemBank();
        $itemBank->setCode($concepto1->getId());
        $manager->persist($itemBank);
        
        $concepto2 = new Concepto();
        $concepto2->setTitulo("Segundo concepto sucesora de 1");
        $concepto2->setDescripcion("descripcion del segundo Concepto");
        $concepto2->setTema($this->getReference('curso-matematicas-tema1'));
        $concepto2->getPredecesoras()->add($concepto1);
        $concepto2->setOrden(1);
        $concepto2->setHabilitado(true);
        $manager->persist($concepto2);
        $manager->flush();
        
        $itemBank = new ItemBank(ItemType::TWO_PL, array(-2,3), ThetaEstimationMethodType::THETA_MLE, 0, 0.1);
        $itemBank->setCode($concepto2->getId());
        $manager->persist($itemBank);
        
        $concepto3 = new Concepto();
        $concepto3->setTitulo("tercer concepto sucesora de 1");
        $concepto3->setDescripcion("descripcion del tercer Concepto");
        $concepto3->setTema($this->getReference('curso-matematicas-tema1'));
        $concepto3->getPredecesoras()->add($concepto1);
        $concepto3->setOrden(1);
        $concepto3->setHabilitado(false);
        $manager->persist($concepto3);
        $manager->flush();

        $itemBank = new ItemBank();
        $itemBank->setCode($concepto3->getId());
        $manager->persist($itemBank);

        
        $concepto4 = new Concepto();
        $concepto4->setTitulo("4 concepto sucesora de 1");
        $concepto4->setDescripcion("descripcion del 4 Concepto");
        $concepto4->setTema($this->getReference('curso-matematicas-tema1'));
        $concepto4->getPredecesoras()->add($concepto2);
        $concepto4->getPredecesoras()->add($concepto3);
        $concepto4->setOrden(1);
        $concepto4->setHabilitado(true);
        $manager->persist($concepto4);
        $manager->flush();
        
        $itemBank = new ItemBank();
        $itemBank->setCode($concepto4->getId());
        $manager->persist($itemBank);

        
        $concepto5 = new Concepto();
        $concepto5->setTitulo("5 concepto");
        $concepto5->setDescripcion("descripcion del 5 Concepto");
        $concepto5->setTema($this->getReference('curso-matematicas-tema1'));
        $concepto5->setOrden(1);
        $concepto5->setHabilitado(true);
        $manager->persist($concepto5);
        $manager->flush();
        
        $itemBank = new ItemBank();
        $itemBank->setCode($concepto5->getId());
        $manager->persist($itemBank);

        
        $manager->flush();

        $this->addReference('curso-matematicas-tema1-concepto1', $concepto1);
        $this->addReference('curso-matematicas-tema1-concepto2', $concepto2);
        $this->addReference('curso-matematicas-tema1-concepto3', $concepto3);
        $this->addReference('curso-matematicas-tema1-concepto4', $concepto4);
        $this->addReference('curso-matematicas-tema1-concepto5', $concepto5);
        
    }

    public function getOrder() {
        return 8;
    }

}
