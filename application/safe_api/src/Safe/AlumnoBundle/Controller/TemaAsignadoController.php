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
class TemaAsignadoController extends SafeRestAbstractController {
     
    
    /**
     * Lista todos los temas asignados al alumno
     *
     * @ApiDoc(     
     *   output = "array<Safe\AlumnoBundle\Entity\TemaAsignado>",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Número de página.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="Cantidad de elementos a retornar.")
     *
     * @Annotations\View(
     *  templateVar="pages"
     * )
     *
     * @param Request               $alumnoId      id del alumno.
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getTemasAction($alumnoId, $cursoId, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        
        return $this->generarRespuesta($this->getTemaAsignadoService()->findAll($alumnoId, $cursoId, $limit, $offset),
                Response::HTTP_OK,
                array('Default'));
    } 
    
    /**
     * Obtiene el detalle del curso asignado al alumno.
     *
     * @ApiDoc(
     *   output = "Safe\TemaBundle\Entity\Tema",
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
    public function getProximo_temaAction($alumnoId, $cursoId)
    {              
        $proximoResultado = $this->getTemaAsignadoService()->proximoTema($cursoId, $alumnoId);
        
        return $this->generarRespuesta($proximoResultado,
                Response::HTTP_OK,
                array('Default', 'alumno_tema_detalle'));
    }
    
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
    public function getProxima_actividadAction($alumnoId, $cursoId)
    {              
         $proximoResultado = $this->getTemaAsignadoService()->proximaActividad($cursoId, $alumnoId);
        
        return $this->generarRespuesta($proximoResultado,
                Response::HTTP_OK,
                array('Default', 'alumno_tema_detalle', 'alumno_concepto_detalle', 'alumno_actividad_detalle'));
    }
    
    /**
     * Obtiene el detalle del tema asignado al alumno.
     *
     * @ApiDoc(
     *   output = "Safe\TemaBundle\Entity\Tema",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Curso no econtrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $docenteId      id del docente.
     * @param int     $id      id del curso.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el curso.
     */
    public function getTemaAction($alumnoId, $cursoId, $temaId)
    {      
        $tema =  $this->getTemaAsignadoService()->getById($temaId);
        return $this->generarRespuesta($tema,
                Response::HTTP_OK,
                array('Default', 'alumno_tema_detalle'));
    }
    
    private function getTemaAsignadoService() {
        return $this->container->get('safe_alumno.service.tema_asignado');
    }
    
    protected function procesarEntidadValida($curso, $method = HttpMethod::POST){

    }
}
