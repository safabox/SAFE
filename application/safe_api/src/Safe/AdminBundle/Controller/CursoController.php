<?php
namespace Safe\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\AdminBundle\Form\RegistracionCursoType;
use Safe\CursoBundle\Entity\Curso;

use Safe\CoreBundle\Controller\SafeRestAbstractController;
use Safe\CoreBundle\Http\HttpMethod;

use Doctrine\Common\Util\Debug;


class CursoController extends SafeRestAbstractController {
    /**
     * Lista todos los cursos
     *
     * @ApiDoc(
     *   resource = true,
     *   output="array<Safe\CursoBundle\Entity\Curso>",
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
    public function getCursosAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        return $this->generarRespuesta($this->getCursoService()->findAll($limit, $offset),
                Response::HTTP_OK,
                array('Default', 'admin_listado'));
    } 
    
    /**
     * Crea un nuevo curso
     * Nota: el usuario no debe existir.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Matemáticas 1",
     *   "descripcion" : "<h1>Curso inical de matemáticas</h1>",
     *   "docente": "13"
     *  }
     * ```
     * @ApiDoc(          
     *   input = "Safe\AdminBundle\Form\RegistracionCursoType",
     *   output="Safe\CursoBundle\Entity\Curso",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postCursoAction(Request $request) {        
        return $this->procesarRequest($request, RegistracionCursoType::class, new Curso(), HttpMethod::POST);        
    }
    
    /**
     * Actualiza los datos del curso
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Matemáticas 1",
     *   "descripcion" : "<h1>Curso inical de matemáticas</h1>",
     *   "docente": "13"
     *  }
     * ```
     * @ApiDoc(          
     *   input = "Safe\AdminBundle\Form\RegistracionAlumnoType",
     *   output="Safe\AlumnoBundle\Entity\Alumno",
     *   statusCodes = {
     *     204 = "Entidad actualizada correctamente",
     *     400 = "Hubo un error al actualizar la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function putCursoAction(Request $request, $id) {                
        $curso = $this->getCursoService()->getById($id);        
        if ($curso == null) {                      
            throw  $this->createNotFoundException("cursoBundle.curso.no_encontrado");
        }            
        return $this->procesarRequest($request, RegistracionCursoType::class, $curso, HttpMethod::PUT);         
    }
    
    /**
     * Actualiza los datos parciales del curso
     * Nota: el usuario no debe existir.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *   "titulo" : "Matemáticas 1",
     *   "descripcion" : "<h1>Curso inical de matemáticas</h1>",
     *   "docente": "13"
     *  }
     * ```
     * @ApiDoc(          
     *   input = "Safe\AdminBundle\Form\RegistracionCursoType",
     *   output="Safe\CursoBundle\Entity\Curso",
     *   statusCodes = {
     *     204 = "Entidad actualizada correctamente",
     *     400 = "Hubo un error al actualizar parcialmente la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function patchCursoAction(Request $request, $id) {                
        $alumno = $this->getCursoService()->getById($id);        
        if ($alumno == null) {        
            throw  $this->createNotFoundException("cursoBundle.curso.no_encontrado");
        }   
        return $this->procesarRequest($request, RegistracionCursoType::class, $alumno, HttpMethod::PATCH); 
    }
        
    /**
     * Obtiene el curso segun el  id
     *
     * @ApiDoc(     
     *   output = "Safe\CursoBundle\Entity\Curso",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Entidad no encontrada"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $id      id del curso.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el curso.
     */
    public function getCursoAction($id)
    {        
        return generarRespuesta($this->getCursoService()->getById($id), Response::HTTP_OK, array('detalle'));
    } 
       
    private function getCursoService() {
        return $this->container->get('safe_curso.service.curso');
    }
    
    /*
     *
     */
    protected function procesarEntidadValida($curso, $method = HttpMethod::POST) {
        $this->getCursoService()->crearOActualizar($curso);        
        if (HttpMethod::POST == $method) {
            return $this->generarRespuesta($curso, Response::HTTP_OK, array('Default', 'admin_listado'));
        }
        return $this->generarRepuestaNotContent();
    }

}
