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
class TemaAsignadoController extends SafeRestAbstractController {
     
    
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
    public function getProximoTemaAction($docenteId, $id)
    {      
        return "";
    }
    
    
    private function getCursoAsignadoService() {
        return $this->container->get('safe_alumno.service.curso_asignado');
    }
    
    protected function procesarEntidadValida($curso, $method = HttpMethod::POST){

    }
}
