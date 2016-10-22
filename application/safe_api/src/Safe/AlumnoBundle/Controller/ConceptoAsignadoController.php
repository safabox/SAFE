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
class ConceptoAsignadoController extends SafeRestAbstractController {
     
    
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
