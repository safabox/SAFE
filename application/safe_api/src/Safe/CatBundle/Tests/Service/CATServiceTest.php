<?php
namespace Safe\CatBundle\Tests\Service;
use Liip\FunctionalTestBundle\Test\WebTestCase;

use Safe\CatBundle\Tests\Service\SafeCATServiceTest;
use Safe\CatBundle\Entity\ExamineeTestStatus;
use Doctrine\Common\Util\Debug;

class CATServiceTest extends SafeCATServiceTest {
    
    public function testGetNextItemFor_withItemBankCodeAndExamineeCode_returnItem() {
        $examineeCode = 1;
        $itemBankCode = 1;
        
        $result = $this->getInstance()->getNextItemFor($itemBankCode, $examineeCode);
        $this->assertNotNull($result);
        $this->assertEquals(0.25, $result->getB());
        
    }
    public function testGetNextItemAction_withItemBankCodeAndNewExaminee_returnItemAndRegisterNewAbilityForExaminee() {
        $examineeCode = 2;
        $itemBankCode = 1;
        $prevAbility = $this->getAbility($examineeCode, $itemBankCode);
        $this->assertNull($prevAbility);
        
        $result = $this->getInstance()->getNextItemFor($itemBankCode, $examineeCode);
        
        $postAbility = $this->getAbility($examineeCode, $itemBankCode);
        $this->assertNotNull($postAbility);
        $this->assertEquals(0, $postAbility->getTheta());
        
        $this->assertNotNull($result);
        $this->assertEquals(0, $result->getB());
        
    }
    
    public function testGetNextItemAction_withItemBankCodeAndExamineeWithAllItemResult_returnNull() {
        $examineeCode = 3;
        $itemBankCode = 1;
 
        $result = $this->getInstance()->getNextItemFor($itemBankCode, $examineeCode);
        
        $this->assertNull($result);        
    }
    
    public function testGetExamineeStatusFor_withItemBankCodeAndExamineeCode_withRequeridedTheta_returnStatusWithPass(){
        $itemBankCode = 1;
        
        $examineeTestStatus = $this->getInstance()->getExamineeStatusFor($itemBankCode, 1);
        
        $this->assertEquals(ExamineeTestStatus::APPROVED, $examineeTestStatus->getStatus());
        $this->assertEquals(-0.1, $examineeTestStatus->getEstimatedError(), '', 0);
        
        $examineeTestStatus = $this->getInstance()->getExamineeStatusFor($itemBankCode, 3);
        
        $this->assertEquals(ExamineeTestStatus::APPROVED_WITH_ERROR, $examineeTestStatus->getStatus());
        $this->assertEquals(-0.5, $examineeTestStatus->getEstimatedError(), '', 0);

        $examineeTestStatus = $this->getInstance()->getExamineeStatusFor($itemBankCode, 4);
        
        $this->assertEquals(ExamineeTestStatus::FAIL, $examineeTestStatus->getStatus());
        $this->assertEquals(0.1, $examineeTestStatus->getEstimatedError(), '', 0);
    }
 
    public function testSave_with_examineeCodeAndItemCodeAndResult_saveItemResult() {
        $testResult = 1;
        $examinee = $this->getExaminee(1);
        $item = $this->getItem("code_3_1");
        $prevAbility = $this->getAbility($examinee->getCode(), $item->getItemBank()->getCode());
        $prevTheta = $prevAbility->getTheta();
        $prevPastAbilityCount = $prevAbility->getPastAbilities()->count();
        $prevItemResultCount = $item->getItemsResults()->count();
        
        
        $thetaEstimation = $this->getInstance()->registerResult($examinee->getCode(), $item->getCode(), $testResult);
        
        $postAbility = $this->getAbility($examinee->getCode(), $item->getItemBank()->getCode());
        
       
        $this->assertTrue($prevTheta < $postAbility->getTheta(), 'Error theta update');
        $this->assertEquals($prevPastAbilityCount + 1, $postAbility->getPastAbilities()->count());
        
        $postItemResultCount = $this->getItem("code_3_1")->getItemsResults()->count();

        $this->assertEquals($prevItemResultCount + 1, $postItemResultCount, 'Error in itemResult count');
    }
    
    
    public function getInstance() {
        return $this->getContainer()->get('safe_cat.service.cat');    
    }

}
