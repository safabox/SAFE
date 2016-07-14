<?php
namespace Safe\AlumnoBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/*
 * use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Acme\BlogBundle\Exception\InvalidFormException;
use Acme\BlogBundle\Form\PageType;
use Acme\BlogBundle\Model\PageInterface;
 */
//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class AlumnoController extends FOSRestController {
    /**
     * Lista todos los alumnos
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
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
    public function getAlumnosAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        $view = $this->view();
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('alumno_listado')));
       
        return $this->getAlumnoService()->findAll($limit, $offset);
    } 
    
    /**
     * Obtiene un alumno,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtiene el alumno segun el  id",
     *   output = "Safe\AlumnoBundle\Entity\Alumno",
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
    public function getAlumnoAction($id)
    {
        
        $view = $this->view();
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('alumno_detalle')));
       
        return $this->getAlumnoService()->getById($id);
    } 
    
    
    
    
    private function getAlumnoService() {
        return $this->container->get('safe_alumno.service.alumno');
    }
}
