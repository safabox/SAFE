<?php
namespace Safe\TemaBundle\Entity\Evaluador;

use Safe\TemaBundle\Entity\Evaluador\EvaluadorActividad;

class EvaluadorMultipleChoiceMatrix implements EvaluadorActividad {
    
    //resultado = [{id:1, resultado: true}, {id:2, resultado: false}]
    public function evaluar($resultadoEsperado, $resultado) {
      if (count($resultadoEsperado) != count($resultado)) {
            return array('resultado' => false, 'respuesta' => $resultadoEsperado);
        }
        foreach ($resultado as $item){
            if (!$this->matchItem($item, $resultadoEsperado)) {
                return array('resultado' => false, 'respuesta' => $resultadoEsperado);
            }
        }
        return array('resultado' => true, 'respuesta' => $resultadoEsperado);
    }
    
     public function matchItem($item, $resultadoEsperado) {
        foreach ($resultadoEsperado as $itemEsperado) {
            if ($itemEsperado['id'] == $item['id'] && $itemEsperado['resultado'] == $item['resultado']) {
                return true;
            }
        }
        return false;
    }
}
