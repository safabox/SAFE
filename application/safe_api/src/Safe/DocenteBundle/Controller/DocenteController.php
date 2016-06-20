<?php
namespace Safe\DocenteBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class DocenteController extends FOSRestController {
/**
     * List all pages.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pages to return.")
     *
     * @Annotations\View(
     *  templateVar="pages"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getDocentesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
       
        return $this->getDocenteService()->findAll($limit, $offset);
    } 
    
    private function getDocenteService() {
        return $this->container->get('safe_docente.service.docente');
    }
    
    /**
     * Obtiene un docente,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtiene el alumno segun el  id",
     *   output = "Safe\DocenteBundle\Entity\Docente",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $id      id del alumno.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el alumno.
     */
    public function getDocenteAction($id)
    {
        
        //$view = $this->view();
        //$view->setSerializationContext(SerializationContext::create()->setGroups(array('docente_detalle')));
       
        return $this->getDocenteService()->getById($id);
    }
}
