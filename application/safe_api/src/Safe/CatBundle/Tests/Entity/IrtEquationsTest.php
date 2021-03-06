<?php

namespace Safe\CatBundle\Tests\Entity;

use Safe\CatBundle\Entity\ItemType;
use Safe\CatBundle\Entity\Item;
use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\ItemResult;

use Safe\CatBundle\Entity\IrtEquations;
use Safe\CatBundle\Entity\Examinee;

class IrtEquationsTest extends \PHPUnit_Framework_TestCase {

    public function testProbB_with_2pl() {
        $itemBank = new ItemBank(ItemType::TWO_PL);
        $item_b1_a0_5 = new Item(1, 0.5);
        $item_b1_a0_5->setItemBank($itemBank);
        
        $theta_minus3 = -3;
        $result = IrtEquations::probP($theta_minus3, $item_b1_a0_5);        
        $this->assertEquals(0.12, $result, '', 0.01);
        
        $theta_minus1 = -1;
        $result = IrtEquations::probP($theta_minus1, $item_b1_a0_5);        
        $this->assertEquals(0.27, $result, '', 0.01);
        
        $theta_zero = 0;
        $result = IrtEquations::probP($theta_zero, $item_b1_a0_5);        
        $this->assertEquals(0.38, $result, '', 0.01);
        
        $theta_2 = 2;
        $result = IrtEquations::probP($theta_2, $item_b1_a0_5);        
        $this->assertEquals(0.62, $result, '', 0.01);
    }

    public function testProbB_with_3pl() {
        $itemBank = new ItemBank(ItemType::THREE_Pl);
        $item_b1_5_a1_3_c0_2 = new Item(1.5, 1.3, 0.2);
        $item_b1_5_a1_3_c0_2->setItemBank($itemBank);
        
        $theta_minus3 = -3;
        $result = IrtEquations::probP($theta_minus3, $item_b1_5_a1_3_c0_2);        
        $this->assertEquals(0.2, $result, '', 0.01);
        
        $theta_minus1 = -1;
        $result = IrtEquations::probP($theta_minus1, $item_b1_5_a1_3_c0_2);        
        $this->assertEquals(0.23, $result, '', 0.01);
        
        $theta_zero = 0;
        $result = IrtEquations::probP($theta_zero, $item_b1_5_a1_3_c0_2);        
        $this->assertEquals(0.3, $result, '', 0.01);
        
        $theta_2 = 2;
        $result = IrtEquations::probP($theta_2, $item_b1_5_a1_3_c0_2);        
        $this->assertEquals(0.73, $result, '', 0.01);
    }
    
    public function testEstimateNewTheta_with_newton_raphson_2pl() {
         $examinee = new Examinee();
         $itemBank = new ItemBank(ItemType::TWO_PL);
         $item_b_minus1_a1 = new Item(-1, 1);
         $item_b_minus1_a1->setItemBank($itemBank);
     
         $item_b_0_a1_2 = new Item(0, 1.2);
         $item_b_0_a1_2->setItemBank($itemBank);
         
         $item_b_1_a0_8 = new Item(1, 0.8);
         $item_b_1_a0_8->setItemBank($itemBank);
         
         $theta = 1;
         $item_result_1 = ItemResult::fromItem($examinee, $item_b_minus1_a1, 1);
         $item_result_2 = ItemResult::fromItem($examinee, $item_b_0_a1_2, 0);
         $item_result_3 = ItemResult::fromItem($examinee, $item_b_1_a0_8, 1);
         
         
         $thetaEstimation = IrtEquations::estimateNewThetaWithStandarErrorNR($theta, array($item_result_1, $item_result_2, $item_result_3), 0.001);
         
         $this->assertEquals(0.3249, $thetaEstimation->getTheta(), '', 0.0001); //theta
         $this->assertEquals(0.0009, $thetaEstimation->getDiff(), '', 0.0001); //error
         $this->assertEquals(1.23, $thetaEstimation->getStandarError(), '', 0.01); //standar error
    }
    
    public function testEstimateNewTheta_with_newton_raphson_2pl_saturation() {
         $examinee = new Examinee();
         $itemBank = new ItemBank(ItemType::TWO_PL);
         $item_b_minus1_a1 = new Item(-1, 1);
         $item_b_minus1_a1->setItemBank($itemBank);
         
         $item_b_0_a1_2 = new Item(0, 1.2);
         $item_b_0_a1_2->setItemBank($itemBank);
         
         $item_b_1_a0_8 = new Item(1, 0.8);
         $item_b_1_a0_8->setItemBank($itemBank);
         
         $theta = 1;
         $item_result_1 = ItemResult::fromItem($examinee, $item_b_minus1_a1, 1);
         $item_result_2 = ItemResult::fromItem($examinee, $item_b_0_a1_2, 1);
         $item_result_3 = ItemResult::fromItem($examinee, $item_b_1_a0_8, 1);
         
         
         $thetaEstimation = IrtEquations::estimateNewThetaWithStandarErrorNR($theta, array($item_result_1, $item_result_2, $item_result_3), 0.001);
         
         $this->assertEquals(3, $thetaEstimation->getTheta(), '', 0.0001); //theta
    }
    
    public function testEstimateNewThetaML_with_2pl() {
         $examinee = new Examinee();
         $itemBank = new ItemBank(ItemType::TWO_PL);
         $item_b_minus1_a1 = new Item(-1, 1);
         $item_b_minus1_a1->setItemBank($itemBank);
         
         $item_b_0_a1_2 = new Item(0, 1.2);
         $item_b_0_a1_2->setItemBank($itemBank);
         
         $item_b_1_a0_8 = new Item(1, 0.8);
         $item_b_1_a0_8->setItemBank($itemBank);
         
         $theta = 1;
         $item_result_1 = ItemResult::fromItem($examinee, $item_b_minus1_a1, 1);
         $item_result_2 = ItemResult::fromItem($examinee, $item_b_0_a1_2, 0);
         $item_result_3 = ItemResult::fromItem($examinee, $item_b_1_a0_8, 1);
         
         
         $result = IrtEquations::estimateNewThetaWithStandarErrorML($theta, array($item_result_1, $item_result_2, $item_result_3), 0.01);
         
         $this->assertEquals(0.32, $result->getTheta(), '', 0.01); //theta
         $this->assertEquals(-0.68, $result->getDiff(), '', 0.01); //diff
         $this->assertEquals(1.23, $result->getStandarError(), '', 0.01); //standar error
    }
    
    public function testEstimateNewTheta_with_MLE_2pl_saturation() {
         $examinee = new Examinee();
         $itemBank = new ItemBank(ItemType::TWO_PL);
         $item_b_minus1_a1 = new Item(-1, 1);
         $item_b_minus1_a1->setItemBank($itemBank);
         
         $item_b_0_a1_2 = new Item(0, 1.2);
         $item_b_0_a1_2->setItemBank($itemBank);
         
         $item_b_1_a0_8 = new Item(1, 0.8);
         $item_b_1_a0_8->setItemBank($itemBank);
         
         $theta = 1;
         $item_result_1 = ItemResult::fromItem($examinee, $item_b_minus1_a1, 1);
         $item_result_2 = ItemResult::fromItem($examinee, $item_b_0_a1_2, 1);
         $item_result_3 = ItemResult::fromItem($examinee, $item_b_1_a0_8, 1);
         
         
         $result = IrtEquations::estimateNewThetaWithStandarErrorML($theta, array($item_result_1, $item_result_2, $item_result_3), 0.001);
         
         $this->assertEquals(3, $result->getTheta(), '', 0.0001); //theta         
    }
    
    
    public function testEstimateInformation_with_2pl() {
        $itemBank = new ItemBank(ItemType::TWO_PL);
        $item_b_1_a1_5 = new Item(1, 1.5);
        $item_b_1_a1_5->setItemBank($itemBank);
        
        $result = IrtEquations::informationI(-2, $item_b_1_a1_5);
        $this->assertEquals(0.02, $result, '', 0.01); 
        
        $result = IrtEquations::informationI(0, $item_b_1_a1_5);
        $this->assertEquals(0.34, $result, '', 0.01);
        
        $result = IrtEquations::informationI(2, $item_b_1_a1_5);
        $this->assertEquals(0.34, $result, '', 0.01);  
    }
    
    public function testEstimateInformation_with_3pl() {
        $itemBank = new ItemBank(ItemType::THREE_Pl);
        $item_b_1_a1_5_b0_2 = new Item(1, 1.5, 0.2);
        $item_b_1_a1_5_b0_2->setItemBank($itemBank);
        
        $result = IrtEquations::informationI(-2, $item_b_1_a1_5_b0_2);
        $this->assertEquals(0.001, $result, '', 0.001); 
        
        $result = IrtEquations::informationI(0, $item_b_1_a1_5_b0_2);
        $this->assertEquals(0.142, $result, '', 0.001);
        
        $result = IrtEquations::informationI(2, $item_b_1_a1_5_b0_2);
        $this->assertEquals(0.257, $result, '', 0.001);  
    }
    
    public function testEstimateInformation_with_Rash() {
        $itemBank = new ItemBank(ItemType::RASH);
        $item_b_1 = new Item(1);
        $item_b_1->setItemBank($itemBank);
        
        $result = IrtEquations::informationI(-2, $item_b_1);
        $this->assertEquals(0.05, $result, '', 0.01); 
        
        $result = IrtEquations::informationI(0, $item_b_1);
        $this->assertEquals(0.2, $result, '', 0.01);
        
        $result = IrtEquations::informationI(2, $item_b_1);
        $this->assertEquals(0.2, $result, '', 0.01);  
    }
    /*
     * NR es 0.0028 segundos mas rapido
    public function testTimeCompare() {
         $examinee = new Examinee();
         $itemBank = new ItemBank(ItemType::TWO_PL);
         $item_b_minus1_a1 = new Item(-1, 1);
         $item_b_minus1_a1->setItemBank($itemBank);
         
         $item_b_0_a1_2 = new Item(0, 1.2);
         $item_b_0_a1_2->setItemBank($itemBank);
         
         $item_b_1_a0_8 = new Item(1, 0.8);
         $item_b_1_a0_8->setItemBank($itemBank);
         
         $theta = 1;
         $item_result_1 = ItemResult::fromItem($examinee, $item_b_minus1_a1, 1);
         $item_result_2 = ItemResult::fromItem($examinee, $item_b_0_a1_2, 0);
         $item_result_3 = ItemResult::fromItem($examinee, $item_b_1_a0_8, 1);
         
         $time_start = microtime(true);
         for($i = 0; $i< 1000; $i++) {
             $result = IrtEquations::estimateNewThetaWithStandarErrorML($theta, array($item_result_1, $item_result_2, $item_result_3), 0.01);
         }
         
         $time_end = microtime(true);
         $a = ($time_end - $time_start);
         echo "ML: ".$a ."\n";

         $time_start = microtime(true);   
         for($j = 0; $j< 1000; $j++) {
            $result = IrtEquations::estimateNewThetaWithStandarErrorNR($theta, array($item_result_1, $item_result_2, $item_result_3), 0.001);
         }
         $time_end = microtime(true);
         $b = ($time_end - $time_start);
         echo "NR: ".$b."\n";
         
         echo "Result: ". ($a - $b)."\n";
    }*/
}
