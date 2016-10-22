<?php
namespace Safe\CatBundle\Tests\Service;
use Liip\FunctionalTestBundle\Test\WebTestCase;

use Safe\CatBundle\Tests\Service\SafeCATServiceTest;
use Doctrine\Common\Util\Debug;

class CATStadisticServiceTest extends SafeCATServiceTest {
    
    public function testFindAllExamineesStadistics_returnExamineeStadisticList() {
        
        $result = $this->getInstance()->findAllExamineesStadistics();
        
        $this->assertEquals(4, count($result));
        $examineeStadistic = $result[0];
        $this->assertEquals('1', $examineeStadistic->getCode());
        $this->assertEquals(1, count($examineeStadistic->getItemBankStadisticList()));
        $itemBankStadistic = $examineeStadistic->getItemBankStadisticList()[0];
        $this->assertEquals(1, $itemBankStadistic->getItemBankCode());
        $this->assertEquals(125, $itemBankStadistic->getItemsNumbers());
        $this->assertEquals(77, $itemBankStadistic->getItemsResolved());
        $this->assertEquals(38, $itemBankStadistic->getItemsResolvedOk());
        $this->assertEquals(0, $itemBankStadistic->getCurrentTheta());
        $this->assertEquals(1, count($itemBankStadistic->getPastAbilities()));
        $pastAbilitie = $itemBankStadistic->getPastAbilities()[0];
        $this->assertEquals(-1, $pastAbilitie->getTheta());
    }
    
    public function testFindExamineesStadistics_returnExamineeStadisticList() {
        
        $examineeStadistic = $this->getInstance()->findExamineesStadistics(3);
        
        $this->assertEquals('3', $examineeStadistic->getCode());
        $this->assertEquals(1, count($examineeStadistic->getItemBankStadisticList()));
        $itemBankStadistic = $examineeStadistic->getItemBankStadisticList()[0];
        $this->assertEquals(1, $itemBankStadistic->getItemBankCode());
        $this->assertEquals(125, $itemBankStadistic->getItemsNumbers());
        $this->assertEquals(125, $itemBankStadistic->getItemsResolved());
        $this->assertEquals(63, $itemBankStadistic->getItemsResolvedOk());
        $this->assertEquals(0, $itemBankStadistic->getCurrentTheta());
        $this->assertEquals(0, count($itemBankStadistic->getPastAbilities()));
    }
    
    
    public function getInstance() {
        return $this->getContainer()->get('safe_cat.service.cat.stadistic');    
    }

}
