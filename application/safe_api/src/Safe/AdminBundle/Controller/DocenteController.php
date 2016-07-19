<?php
namespace Safe\AdminBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class DocenteController extends FOSRestController {
    /**
     * Lista todos los docentes.
     *
     * @ApiDoc(
     *   resource = true,
     *   output="array<Safe\DocenteBundle\Entity\Docente>",
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
    
    /**
     * Obtiene el docente según el id.
     *
     * @ApiDoc(     
     *   output = "Safe\DocenteBundle\Entity\Docente",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Docente no encontrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $id      id del docente.
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
    
    private function getDocenteService() {
        return $this->container->get('safe_docente.service.docente');
    }
}
