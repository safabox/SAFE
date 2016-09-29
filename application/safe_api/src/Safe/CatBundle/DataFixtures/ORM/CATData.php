<?php
namespace Safe\CatBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\Item;
class CATData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    
    protected $container;
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {        
        $code = $this->getReference('curso-matematicas')->getId();
        $itemBank = new ItemBank($code);
        
        $items = array();
        //Genero 60 x 5 items por banco (300 ejercicios, hay 5 x cada dificultad)
        for($i=-3; $i<=3; $i += 0.1){
            for($j=0; $j < 5; $j++) {
                $item = new Item($i);
                $item->setItemBank($itemBank);
                $items[] = $item;
            }
        }        
        $itemBank->setItems($items);
        
        $manager->persist($itemBank);

        $manager->flush();

        $this->addReference('itemBank-matematicas', $itemBank);
    }

    public function getOrder() {
        return 7;
    }

    
}
