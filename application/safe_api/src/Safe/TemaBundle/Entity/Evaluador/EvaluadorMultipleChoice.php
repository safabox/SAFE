<?php
namespace Safe\TemaBundle\Entity\Evaluador;

use Safe\TemaBundle\Entity\Evaluador\EvaluadorActividad;

class EvaluadorMultipleChoice implements EvaluadorActividad {
    //resultado = [1,3,4]
    public function evaluar($resultadoEsperado, $resultado) {
        if (count($resultadoEsperado) != count($resultado)) {
            return array('resultado' => false, 'respuesta' => $resultadoEsperado);
        }
        foreach ($resultado as $id){
            if (!$this->matchItem($id, $resultadoEsperado)) {
                return array('resultado' => false, 'respuesta' => $resultadoEsperado);
            }
        }
        return array('resultado' => true, 'respuesta' => $resultadoEsperado);
    }
    
    
    public function matchItem($id, $resultadoEsperado) {
        foreach ($resultadoEsperado as $idEsperado) {
            if ($idEsperado == $id) {
                return true;
            }
        }
        return false;
    }
}
