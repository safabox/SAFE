<?php
namespace Safe\TemaBundle\Entity\Evaluador;

/**
 * Description of EvaluadorActividad
 *
 * @author zendar
 */
interface EvaluadorActividad {
    public function evaluar($resultadoEsperado, $resultado);
}
