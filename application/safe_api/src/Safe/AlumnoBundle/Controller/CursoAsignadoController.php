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
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Numero de pagina.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="Cantidad de elementos a retornar.")
     *
     * @Annotations\View(
     *  templateVar="pages"
     * )
     *
     * @param Request               $id      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getCursosAction($alumnoId, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        $view = $this->view();
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('alumno_listado')));
       
        return $this->getCursoAsignadoService()->findAll($alumnoId, $limit, $offset);
    } 
    
    
    private function getCursoAsignadoService() {
        return $this->container->get('safe_alumno.service.curso_asignado');
    }
}
