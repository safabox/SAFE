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

//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class CursoAsignadoController extends SafeRestAbstractController {
    /**
     * Lista todos los cusos asignados al alumno
     *
     * @ApiDoc(     
     *   output = "array<Safe\CursoBundle\Entity\Curso>",
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
     * @param Request               $id      id del alumno.
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getCursosAction($id, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        
        return $this->generarRespuesta($this->getCursoAsignadoService()->findAll($id, $limit, $offset),
                Response::HTTP_OK,
                array('Default'));
    } 
    
    /**
     * Obtiene el detalle del curso asignado al alumno.
     *
     * @ApiDoc(
     *   output = "Safe\CursoBundle\Entity\Curso",
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
    public function getCursoAction($docenteId, $id)
    {      
        $curso =  $this->getCursoAsignadoService()->getById($id);
        return $this->generarRespuesta($curso,
                Response::HTTP_OK,
                array('Default', 'alumno_detalle'));
    }
    
    
    private function getCursoAsignadoService() {
        return $this->container->get('safe_alumno.service.curso_asignado');
    }
    
    protected function procesarEntidadValida($curso, $method = HttpMethod::POST){

    }
}
