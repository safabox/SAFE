<?php
namespace Safe\TemaBundle\Entity\Evaluador;

use Safe\TemaBundle\Entity\Evaluador\EvaluadorDummy;
use Safe\TemaBundle\Entity\Evaluador\EvaluadorMultipleChoice;
use Safe\TemaBundle\Entity\Evaluador\EvaluadorMultipleChoiceMatrix;
class EvaluadorFactory {

    
    public static function crearEvaluador($tipo) {
        
        switch ($tipo) {
            case 'MULTIPLE_CHOICE':
                return new EvaluadorMultipleChoice();
            case 'MULTIPLE_CHOICE_MATRIX':
                return new EvaluadorMultipleChoiceMatrix();
            default:
                return new EvaluadorDummy();
        }
    }
}
