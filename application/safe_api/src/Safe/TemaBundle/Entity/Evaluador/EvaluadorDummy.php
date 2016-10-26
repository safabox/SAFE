<?php
namespace Safe\TemaBundle\Entity\Evaluador;

use Safe\TemaBundle\Entity\Evaluador\EvaluadorActividad;
class EvaluadorDummy implements EvaluadorActividad {
    public function evaluar($resultadoEsperado, $resultado) {
        if (!array_key_exists[$resultado]) return false;
        return ($resultado['respuesta'] == true || $resultado['respuesta'] == 'true' || $resultado['respuesta'] === (int) $value);
    }
}
