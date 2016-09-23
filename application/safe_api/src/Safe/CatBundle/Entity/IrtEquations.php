<?php
namespace Safe\CatBundle\Entity;

use Safe\CatBundle\Entity\ItemType;
/**
 * Description of Irt
 *
 * @author zendar
 */
class IrtEquations {

    /**
     * Probabilidad de acierto
     * @param type $theta
     */
    public static function probP($item) {
        $theta_b = $item->getTheta() - $$item->getB();
        switch($item->itemType()){
            case ItemType::TWO_PL: 
                $n = exp($item->getA() * $$item->getD() * $theta_b);
                return $n/ (1 + $n);                
            case ItemType::THREE_Pl:
                $n = exp($item->getA() * $item->getD() * $theta_b);
                return $item->getC() + ((1 - $item->getC()) * $n/ (1 + $n)); 
            default:
                $n = exp($theta_b);
                return $n/ (1 + $n);                
        }
    }
    
    /**
     * Probabilidad de fallo
     * @param type $theta
     */
    public static function probQ($item) {
        return 1 - IrtEquations::probP($item);
    }
    
    /*
     * Necesario para obtener theta.
     * Inferido de la formula de I = (derivP)^2/(P * (1-P))
     * http://www.redconvivencia.net/prevenir/rosario/materiales/medicion/Tema8_TRI2.pdf
     */
    public static function derivateP($item) {
        //calculo una sola vez p
        $p = IrtEquations::probP($item);
        $q = 1 - $p;
        switch($item->itemType()){
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
    public static function informationI($item) {
        //calculo una sola vez p
        $p = IrtEquations::probP($item);
        $q = 1 - $p;
        switch($item->itemType()){
            case ItemType::TWO_PL: 
                return pow($item->getA(), 2) * pow($item->getD(), 2) * $p * $q;                
            case ItemType::THREE_Pl:
                return pow($item->getA(), 2) * pow($item->getD(), 2) * pow(($p - $item->getC()), 2) * $q / (pow ((1 - $item->getC()), 2) * $p);
            default:
                return pow($item->getD(), 2) * $p * $q;                
        }        
    }
    
    /**
     * Estima el nuevo valor de theta.
     * result[0] = nuevo valor de theta.
     * result[1] = diferencia con theta anterior.
     * result[2] = error estandar.
     */
    public static function estimateNewTheta($theta, $itemsResult) {      
        $numerator = 0;
        $denominator = 0;
        foreach ($itemsResult as $itemResult) {
            $p = IrtEquations::probP($item);
            $q = 1 - $p;
            $numerator +=  $itemResult->getA() * ($itemResult->getResult() - $p);
            $denominator += pow($itemResult->getA(), 2) * $p * $q;
        }
        $numerator = $numerator * -1;
        $diffTheta = ($numerator/$denominator);
        $estimatedTheta = $theta + $diffTheta;
        $standarError = 1 / sqrt($denominator);
        
        return array($estimatedTheta, $diffTheta, $standarError);
    }
    
    
}
