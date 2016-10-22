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
use Safe\AlumnoBundle\Entity\ProximoResultado;
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
    
    
    private function getActividadAsignadaService() {
        return $this->container->get('safe_alumno.service.actividad_asignada');
    }
    
    protected function procesarEntidadValida($curso, $method = HttpMethod::POST){

    }
}
