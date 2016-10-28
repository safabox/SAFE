<?php
namespace Safe\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\AdminBundle\Form\RegistracionAlumnoType;
use Safe\AlumnoBundle\Entity\Alumno;

use Safe\CoreBundle\Controller\SafeRestAbstractController;
use Safe\CoreBundle\Http\HttpMethod;
use Safe\CoreBundle\Exception\IllegalArgumentException;


use Doctrine\Common\Util\Debug;


class CursoAlumnoController extends SafeRestAbstractController {
    /**
     * Lista todos los alumnos del curso. (TODO)
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
     * @Annotations\QueryParam(name="limit", requirements="\d+", nullable=true, description="Cantidad de elementos a retornar.")
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
    public function getAlumnosAction($id, Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        return $this->generarRespuesta($this->getAlumnoService()->buscarPorCursos($id, $limit, $offset),
                Response::HTTP_OK,
                array('Default', 'admin_listado'));
    } 
    
    /**
     * Inscribe un alumno al curso.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "id":  "1"
     * } 
     * ```
     * @ApiDoc(          
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postAlumnoAction($id, Request $request) {
        $alumno = $this->obtenerAlumno($request);
        try {
           $this->getCursoService()->inscribirAlCurso($id, $alumno);
           
        } catch(IllegalArgumentException $ex) {
            return $this->generarRepuestaBadRequest($this->traducir($ex->getMessage()));
        }  
        return $this->generarRepuestaNotContent();
    }
    
    /**
     * Desinscribe un alumno al curso.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "id":  "1"
     * } 
     * ```
     * @ApiDoc(          
     *   statusCodes = {
     *     204 = "Entidad eliminada correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function deleteAlumnoAction($id, Request $request) {
        $alumno = $this->obtenerAlumno($request);
        try {
           $this->getCursoService()->desinscribirDelCurso($id, $alumno);
           
        } catch(IllegalArgumentException $ex) {
            return $this->generarRepuestaBadRequest($this->traducir($ex->getMessage()));
        }  
        return $this->generarRepuestaNotContent();
    }
    
    private function obtenerAlumno($request) {
        $idAlumno = $this->obtenerIdentificadorPostRequest($request);
        $alumno = $this->getAlumnoService()->getById($idAlumno);
        if ($alumno === NULL) {
            throw $this->createNotFoundException();
        }
        return $alumno;
    }
    
       
    private function getAlumnoService() {
        return $this->container->get('safe_alumno.service.alumno');
    }
    
    private function getCursoService() {
        return $this->container->get('safe_curso.service.curso');
    }
    
    protected function procesarEntidadValida($alumno, $method = HttpMethod::POST) {
        
        
        
        $this->getAlumnoService()->crearOActualizar($alumno);        
        if (HttpMethod::POST == $method) {            
            return $this->generarRespuesta($alumno, Response::HTTP_OK, array('Default', 'admin_listado'));
        }
        return $this->generarRepuestaNotContent();
    }

}
