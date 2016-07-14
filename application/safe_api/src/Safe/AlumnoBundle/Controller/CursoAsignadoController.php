<?php
namespace Safe\AlumnoBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class CursoAsignadoController extends FOSRestController {
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
        
        $view = $this->view();
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('alumno_listado')));
       
        return $this->getCursoAsignadoService()->findAll($id, $limit, $offset);
    } 
    
    
    private function getCursoAsignadoService() {
        return $this->container->get('safe_alumno.service.curso_asignado');
    }
}
