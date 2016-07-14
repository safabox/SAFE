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
     * Lista todos los cusos impartidos por el docente.
     *
     * @ApiDoc(
     *   output = "array<Safe\CursoBundle\Entity\Curso>",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente"
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
     * @param Request               $id      id del docente
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getCursosAction($id, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        //$view = $this->view();
        //$view->setSerializationContext(SerializationContext::create()->setGroups(array('docente_curso_listado')));
       
        return $this->getCursoImpartidoService()->findAll($id, $limit, $offset);
    } 
    
    /**
     * Obtiene el detalle del curso impartido por el docente.
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
        $curso =  $this->getCursoImpartidoService()->getById($id);
        return $curso;
    }
    
    
    private function getCursoImpartidoService() {
        
        return $this->container->get('safe_docente.service.curso_impartido');       
    }
}
