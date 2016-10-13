<?php
namespace Safe\CatBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\Item;
use Safe\CatBundle\Entity\ItemResult;
use Safe\CatBundle\Entity\Examinee;
use Safe\CatBundle\Entity\Ability;
use \Safe\CatBundle\Entity\PastAbility;


use Doctrine\Common\Util\Debug;

class CATData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $itemBank = new ItemBank();
        $itemBank->setCode($this->getReference('curso-matematicas')->getId());
        $manager->persist($itemBank);
        
        $examinee = new Examinee();
        $examinee->setCode($this->getReference('alumno1')->getId());
        $manager->persist($examinee);
 
        $examinee2 = new Examinee();
        $examinee2->setCode($this->getReference('alumno2')->getId());
        $manager->persist($examinee2);
        
        $examinee3 = new Examinee();
        $examinee3->setCode($this->getReference('alumno3')->getId());
        $manager->persist($examinee3);
 
        
        $theta = 0;
        
        $ability = new Ability($examinee, $itemBank, $theta);
        $manager->persist($ability);
        $pastAbility = new PastAbility($ability);
        $pastAbility->setTheta(-1);
        $manager->persist($pastAbility);
  
        $ability3 = new Ability($examinee3, $itemBank, $theta);
        $manager->persist($ability3);
  
        
        $items = array();
        $result = 0;
        for($i=-3; $i <= 3; $i += 0.25) {
            for($j=0; $j < 5; $j++){
                $item = new Item($i);
                $item->setItemBank($itemBank);
                $item->setCode("code_".$i."_".$j);
                $items[] = $item;
                $manager->persist($item);
                if ($j % 2 == 0 || $theta == $i) {
                    $itemResult = ItemResult::fromItem($examinee, $item, $result);
                    $manager->persist($itemResult);
                    $result = ($result == 0) ? 1 : 0;
                }
                //Add resut for Examinee3 (has all item finished)
                $itemResult = ItemResult::fromItem($examinee3, $item, $result);
                $manager->persist($itemResult);                
            }
        }       

        $manager->flush();
        $this->addReference('itembank-curso-matematicas', $itemBank);
        $this->addReference('examinee-alumno1', $examinee);
        $this->addReference('ability-alumno1-curso-matematicas', $ability);
    }

    public function getOrder() {
        return 8;
    }

}
