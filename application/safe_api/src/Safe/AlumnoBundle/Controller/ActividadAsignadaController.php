<?php
namespace Safe\AlumnoBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\CoreBundle\Controller\SafeRestAbstractController;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
use Doctrine\Common\Util\Debug;
//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class ActividadAsignadaController extends SafeRestAbstractController {
     
    
    /**
     * Obtiene la proxima actividad para el alumno.
     *
     * @ApiDoc(
     *   output = "Safe\CursoBundle\Entity\Actividad",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Curso no econtrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $alumnoId      id del alumno.
     * @param int     $cursoId      id del curso.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el curso.
     */
    public function getProxima_actividadAction($alumnoId, $cursoId, $temaId, $conceptoId)
    {              
        $proximoResultado = $this->getActividadAsignadaService()->proximaActividad($conceptoId, $alumnoId);        
        return $this->generarRespuesta($proximoResultado,
                Response::HTTP_OK,
                array('Default', 'alumno_actividad_detalle'));
    }
    
    /**
     * Registra un resultado de la actividad.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "resultado" : [],
     *  }
     * ```
     * @ApiDoc(          
     *   output="Safe\TemaBundle\Entity\Actividad",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postResultadoAction($alumnoId, $cursoId, $temaId, $conceptoId, $actividadId)
    {              
        $data = json_decode($request->getContent(), true);
        $validacion = $this->validarRequestData($data);
        if (!$validacion['resultado']) {
            return $this->generarRepuestaBadRequest($validacion['mensaje']);
        }
        $proximoResultado = $this->getActividadAsignadaService()->registrarResultado($actividadId, $data['resultado']);        
        return $this->generarRespuesta($proximoResultado,
                Response::HTTP_OK,
                array('Default', 'alumno_actividad_detalle'));
    }
    
    
    private function getActividadAsignadaService() {
        return $this->container->get('safe_alumno.service.actividad_asignada');
    }
    
    protected function procesarEntidadValida($curso, $method = HttpMethod::POST){

    }
    
    private function validarRequestData($data) {
        if (!array_key_exists('resultado', $data)) {
            return array('resultado' => false, 'mensaje' => $this->traducir("temaBundle.actividad.resultado.vacio"));
        }
        return array('resultado' => true);
    }
}
