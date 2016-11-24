<?php
namespace Safe\CatBundle\Entity;

use Safe\CatBundle\Entity\ItemType;
use Safe\CatBundle\Entity\ItemResult;
use Safe\CatBundle\Entity\ThetaEstimation;
use Symfony\Bridge\Monolog\Logger;

/**
 * Description of Irt
 *
 * @author zendar
 */
use Doctrine\Common\Util\Debug;
class IrtEquations {

    /**
     * Probabilidad de acierto
     * @param type $theta
     */
    public static function probP($theta, $item) {
        $theta_b = $theta - $item->getB();
        switch($item->getItemType()){
            case ItemType::TWO_PL: 
                $n = exp($item->getA() * $item->getD() * $theta_b);
                return $n/ (1 + $n);                
            case ItemType::THREE_Pl:
                //$n = exp($item->getA() * $item->getD() * $theta_b);
                //return $item->getC() + ((1 - $item->getC()) * $n/ (1 + $n)); 
                $n = exp(-1 * $item->getA() * $item->getD() * $theta_b);
                return $item->getC() + ((1 - $item->getC())/(1 + $n)); 
            default:
                $n = exp($theta_b);
                return $n/ (1 + $n);                
        }
    }
    
    /**
     * Probabilidad de fallo
     * @param type $theta
     */
    public static function probQ($theta, $item) {
        return 1 - IrtEquations::probP($theta, $item);
    }
    
    /*
     * Necesario para obtener theta.
     * Inferido de la formula de I = (derivP)^2/(P * (1-P))
     * http://www.redconvivencia.net/prevenir/rosario/materiales/medicion/Tema8_TRI2.pdf
     */
    public static function derivateP($theta, $item) {
        //calculo una sola vez p
        $p = IrtEquations::probP($theta, $item);
        $q = 1 - $p;
        switch($item->getItemType()){
            case ItemType::TWO_PL: 
                return $item->getA() * $item->getD() * $p * $q;               
            case ItemType::THREE_Pl:
                return $item->getA() * $item->getD() * $q * ($p - $item->getC()) / (1 - $item->getC());
            default:
                $n = exp($theta_b);
                return $item->getD() * $p * $q;                
        }
    }
    
    /*
     * Informacion del item.
     */
    public static function informationI($theta, $item) {
        //calculo una sola vez p
        $p = IrtEquations::probP($theta, $item);
        $q = 1 - $p;
        switch($item->getItemType()){
            case ItemType::TWO_PL: 
                return pow($item->getA(), 2) * pow($item->getD(), 2) * $p * $q;                
            case ItemType::THREE_Pl:
                return pow($item->getA(), 2) * pow($item->getD(), 2) * pow(($p - $item->getC()), 2) * $q / (pow ((1 - $item->getC()), 2) * $p);
            default:
                return pow($item->getD(), 2) * $p * $q;                
        }        
    }
    
    /**
     * Estima el nuevo valor de theta con newton rapshon
     * result[0] = nuevo valor de theta.
     * result[1] = diferencia con theta anterior.
     * result[2] = error estandar.
     */
    public static function estimateNewThetaWithStandarErrorNR($theta, $itemsResult, $error = 0.001, $limit = array(-3, 3), Logger $logger = null) {      
        $numerator = 0;
        $denominator = 0;        
        if (count($itemsResult) <= 1) {             
             return new ThetaEstimation($theta, 99, 99);
        }
        foreach ($itemsResult as $itemResult) {
            $p = IrtEquations::probP($theta, $itemResult);
            $q = 1 - $p;
            if ($itemResult->getA() == 0) {
                $denominator += $p * $q;
                $num =  $itemResult->getResult() - $p;
            } else {
                $num = $itemResult->getA() * ($itemResult->getResult() - $p);            
                $denominator += pow($itemResult->getA(), 2) * $p * $q;     
            }
            $numerator +=  $num;
        }
        //$numerator = $numerator * -1;
        $diffTheta = ($numerator/$denominator);       
        $unsignedDiffTheta = ($diffTheta < 0) ? (-1 * $diffTheta) : $diffTheta;         
        $estimatedTheta = $theta + $diffTheta;
        if ($unsignedDiffTheta < $error || $estimatedTheta < $limit[0] || $estimatedTheta > $limit[1]) {
            if ($estimatedTheta < $limit[0]) {
                $estimatedTheta = $limit[0];
            } else if ($estimatedTheta > $limit[1]) {
                $estimatedTheta = $limit[1];
            }
            
            $standarError = 1 / sqrt($denominator);
            return new ThetaEstimation($estimatedTheta, $diffTheta, $standarError);
        }
        return IrtEquations::estimateNewThetaWithStandarErrorNR($estimatedTheta, $itemsResult, $error, $limit, $logger);
        
    }
    
    public static function estimateNewThetaWithStandarErrorML($theta, $itemsResult, $increment = 0.25, $limit = array(-3, 3), Logger $logger = null) {              
        $maxLikehoodSum = null;
        $maxTheta = $limit[0];        
        $thetaLimit = $increment + $limit[1];

        for($thetaEval=$limit[0]; $thetaEval < $thetaLimit; $thetaEval += $increment) {
            $thetaEval = ($thetaEval > $limit[1]) ? $limit[1] : $thetaEval;
            $likelihoodSum = 0;
            foreach ($itemsResult as $itemResult) {
                $p = IrtEquations::probP($thetaEval, $itemResult);
                $q = 1 - $p;
                $u = $itemResult->getResult();
                $logP = log10($p);
                $logQ = log10($q);
                $likelihood = ($u * $logP) + ((1 - $u) * $logQ);
                $likelihoodSum += $likelihood;
            }         
            if ($maxLikehoodSum == null || $likelihoodSum > $maxLikehoodSum) {
                $maxLikehoodSum = $likelihoodSum;
                $maxTheta = $thetaEval;
            }            
        }
        $denominatorSum = 0;
        foreach ($itemsResult as $itemResult) {
            $p = IrtEquations::probP($maxTheta, $itemResult);
            $alpha_pow2 =  pow($itemResult->getA(), 2) * pow($itemResult->getD(), 2);
            $denominator = $alpha_pow2 * $p * (1 - $p);
            $denominatorSum += $denominator;
        }        
        if ($denominatorSum == 0) {
            $standarError = 999;
        } else {
            $standarError = 1 / sqrt($denominatorSum);
        }        
        return new ThetaEstimation($maxTheta, $maxTheta - $theta, $standarError, $logger);
    }
    
}
