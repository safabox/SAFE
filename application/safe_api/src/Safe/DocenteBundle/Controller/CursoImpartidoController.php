<?php
namespace Safe\DocenteBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class CursoImpartidoController extends FOSRestController {
    /**
     * Lista todos los cusos impartido por el docente
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
    public function getCursosAction($docenteId, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        //$view = $this->view();
        //$view->setSerializationContext(SerializationContext::create()->setGroups(array('docente_curso_listado')));
       
        return $this->getCursoImpartidoService()->findAll($docenteId, $limit, $offset);
    } 
    
    /**
     * Obtiene un curso,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtiene el alumno segun el  id",
     *   output = "Safe\CursoBundle\Entity\Curso",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
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
        $curso =  $this->getCursoImpartidoService()->getById($id);
        return $curso;
    }
    
    
    private function getCursoImpartidoService() {
        
        return $this->container->get('safe_docente.service.curso_impartido');       
    }
}
