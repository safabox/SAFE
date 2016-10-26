<?php
namespace Safe\TemaBundle\Entity\Evaluador;

use Safe\TemaBundle\Entity\Evaluador\EvaluadorDummy;
class EvaluadorFactory {

    
    public static function crearEvaluador($tipo) {
        
        switch ($tipo) {
            default:
                return new EvaluadorDummy();
        }
    }
}
