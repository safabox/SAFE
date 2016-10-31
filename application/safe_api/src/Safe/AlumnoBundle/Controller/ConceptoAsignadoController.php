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
class ConceptoAsignadoController extends SafeRestAbstractController {
     
    /**
     * Lista todos los conceptos asignados al alumno
     *
     * @ApiDoc(     
     *   output = "array<Safe\AlumnoBundle\Entity\ConceptoAsignado>",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Número de página.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", nullable=true, description="Cantidad de elementos a retornar.")
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
    public function getConceptosAction($alumnoId, $cursoId, $temaId, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        
        return $this->generarRespuesta($this->getConceptoAsignadoService()->findAll($alumnoId, $temaId, $limit, $offset),
                Response::HTTP_OK,
                array('Default'));
    }
    
    /**
     * Obtiene el proximo concepto para el alumno.
     *
     * @ApiDoc(
     *   output = "Safe\TemaBundle\Entity\Concepto",
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
    public function getProximo_conceptoAction($alumnoId, $cursoId, $temaId)
    {              
        $proximoResultado = $this->getConceptoAsignadoService()->proximoConcepto($temaId, $alumnoId);
        
        return $this->generarRespuesta($proximoResultado,
                Response::HTTP_OK,
                array('Default', 'alumno_concepto_detalle'));
    }
    
    /**
     * Obtiene la proxima actividad para el alumno.
     *
     * @ApiDoc(
     *   output = "Safe\AlumnoBundle\Entity\ConceptoProximaActividad",
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
    public function getProxima_actividadAction($alumnoId, $cursoId, $temaId)
    {              
        $proximoResultado = $this->getConceptoAsignadoService()->proximaActividad($temaId, $alumnoId);
        
        return $this->generarRespuesta($proximoResultado,
                Response::HTTP_OK,
                array('Default', 'alumno_actividad_detalle'));
    }
    
    /**
     * Obtiene el detalle del concepto.
     *
     * @ApiDoc(
     *   output = "Safe\TemaBundle\Entity\Concepto",
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
     * @param int     $conceptoId      id del concepto.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el curso.
     */
    public function getConceptoAction($alumnoId, $cursoId, $temaId, $conceptoId)
    {              
        $concepto = $this->getConceptoAsignadoService()->getById($conceptoId);
        
        return $this->generarRespuesta($concepto,
                Response::HTTP_OK,
                array('Default', 'alumno_concepto_detalle'));
    }
    
    
    private function getConceptoAsignadoService() {
        return $this->container->get('safe_alumno.service.concepto_asignado');
    }
    
    protected function procesarEntidadValida($curso, $method = HttpMethod::POST){

    }
}
