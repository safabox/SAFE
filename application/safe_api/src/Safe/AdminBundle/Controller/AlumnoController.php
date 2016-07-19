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

use Doctrine\Common\Util\Debug;


class AlumnoController extends SafeRestAbstractController {
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
        
        return $this->generarRespuesta($this->getAlumnoService()->findAll($limit, $offset),
                Response::HTTP_OK,
                array('listado', 'admin_listado'));
    } 
    
    /**
     * Crea un nuevo alumno
     * Nota: el usuario no debe existir.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "legajo":  "123457",
     *  "usuario": {
     *      "nombre": "Roberto",
     *      "apellido": "Gómez Bolaño",
     *      "username": "chespirito",
     *      "email": "chespirito@organizacion.org",
     *      "enabled": "true",
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      }
     *	}
     * } 
     * ```
     * @ApiDoc(          
     *   input = "Safe\AdminBundle\Form\RegistracionAlumnoType",
     *   output="Safe\AlumnoBundle\Entity\Alumno",
     *   statusCodes = {
     *     204 = "Entidad creadad correctamente",
     *     400 = "Hubo un error al crear la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postAlumnoAction(Request $request) {        
        return $this->procesarRequest($request, new RegistracionAlumnoType(), new Alumno(), HttpMethod::POST);        
    }
    
    /**
     * Actualiza los datos del alumno
     * Nota: el usuario no debe existir.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "legajo":  "123457",
     *  "usuario": {
     *      "nombre": "Roberto",
     *      "apellido": "Gómez Bolaño",
     *      "username": "chespirito",     
     *      "email": "chespirito@organizacion.org",
     *      "enabled": "true", 
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      }
     *	}
     * } 
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
    public function putAlumnoAction(Request $request, $id) {                
        $alumno = $this->getAlumnoService()->getById($id);        
        if ($alumno == null) {                      
            throw  $this->createNotFoundException("alumnoBundle.alumno.no_encontrado");
        }            
        return $this->procesarRequest($request, new RegistracionAlumnoType(), $alumno, HttpMethod::PUT);         
    }
    
    /**
     * Actualiza los datos parciales del alumno
     * Nota: el usuario no debe existir.
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "legajo":  "123457",
     *  "usuario": {
     *      "nombre": "Roberto",
     *      "apellido": "Gómez Bolaño",
     *      "username": "chespirito",     
     *      "email": "chespirito@organizacion.org",
     *      "enabled": "true", 
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      }
     *	}
     * } 
     * ```
     * @ApiDoc(          
     *   input = "Safe\AdminBundle\Form\RegistracionAlumnoType",
     *   output="Safe\AlumnoBundle\Entity\Alumno",
     *   statusCodes = {
     *     204 = "Alumno actualizado correctamente",
     *     400 = "Hubo un error al actualizar parcialmente el alumno"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function patchAlumnoAction(Request $request, $id) {                
        $alumno = $this->getAlumnoService()->getById($id);        
        if ($alumno == null) {        
            throw  $this->createNotFoundException("alumnoBundle.alumno.no_encontrado");
        }   
        return $this->procesarRequest($request, new RegistracionAlumnoType(), $alumno, HttpMethod::PATCH); 
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
        return generarRespuesta($this->getAlumnoService()->getById($id), Response::HTTP_OK, array('detalle'));
    } 
       
    private function getAlumnoService() {
        return $this->container->get('safe_alumno.service.alumno');
    }
    
    /*
     *
     */
    protected function procesarEntidadValida($alumno, $method = HttpMethod::POST) {
        $this->getAlumnoService()->crearOActualizar($alumno);        
        if (HttpMethod::POST == $method) {
            return $this->generarRespuesta($alumno, Response::HTTP_OK, array('listado', 'admin_listado'));
        }
        return $this->generarRepuestaNotContent();
    }

}
