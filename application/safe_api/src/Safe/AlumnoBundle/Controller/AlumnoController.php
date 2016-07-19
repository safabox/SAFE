<?php
namespace Safe\AlumnoBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;

use JMS\Serializer\SerializationContext;

use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class AlumnoController extends FOSRestController {
    /**
     * Lista todos los alumnos
     *
     * @ApiDoc(
     *   resource = true,
     *   output="array<Safe\AlumnoBundle\Entity\Alumno>",
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
    public function getAlumnosAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        $view = $this->view($this->getAlumnoService()->findAll($limit, $offset), Response::HTTP_OK);
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('listado')));
        return $this->handleView($view);
    } 
    
    /**
     * Obtiene el alumno segun el  id
     *
     * @ApiDoc(     
     *   output = "Safe\AlumnoBundle\Entity\Alumno",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Alumno no encontrado"
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
