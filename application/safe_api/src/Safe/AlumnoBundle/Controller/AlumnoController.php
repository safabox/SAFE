<?php
namespace Safe\AlumnoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * Actualiza los datos del alumno
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "legajo":  "123457",
     *  "usuario": {
     *      "nombre": "Roberto",
     *      "apellido": "Gómez Bolaño",
     *      "username": "chespirito",     
     *      "tipoDocumento":  "DNI",
     *      "numeroDocumento": "30777555",
     *      "genero": "Masculino",
     *      "email": "chespirito@organizacion.org",
     *      "enabled": "true", 
     *      "textPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      }
     *	}
     * } 
     * ```
     * @ApiDoc(          
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
    public function putAlumnoAction(Request $request, $alumnoId) {                
        $alumno = $this->obtenerAlumno($alumnoId);           
        return $this->procesarRequest($request, new RegistracionAlumnoType(), $alumno, HttpMethod::PUT);         
    }
    
    /**
     * Actualiza los datos parciales del alumno
     * 
     * #### Ejemplo del Request     
     * ```
     * {
     *  "legajo":  "123457",
     *  "usuario": {
     *      "nombre": "Roberto",
     *      "apellido": "Gómez Bolaño",
     *      "username": "chespirito",     
     *      "tipoDocumento":  "DNI",
     *      "numeroDocumento": "30777555",
     *      "genero": "Masculino",
     *      "email": "chespirito@organizacion.org",
     *      "enabled": "true", 
     *      "textPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      }
     *	}
     * } 
     * ```
     * @ApiDoc(          
     *   output="Safe\AlumnoBundle\Entity\Alumno",
     *   statusCodes = {
     *     204 = "Entidad actualizada correctamente",
     *     400 = "Hubo un error al actualizar parcialmente la entidad"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function patchAlumnoAction(Request $request, $alumnoId) {                
        $alumno = $this->obtenerAlumno($alumnoId);  
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
     * @param int     $alumnoId      id del alumno.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el alumno.
     * @throws AccessDeniedHttpException.
     */
    public function getAlumnoAction($alumnoId)
    {        
        $alumno = $this->obtenerAlumno($alumnoId);
        return $this->generarRespuesta($alumno, Response::HTTP_OK, array('Default', 'detalle'));
    } 
    
    protected function procesarEntidadValida($alumno, $method = HttpMethod::POST) {
        $this->getAlumnoService()->crearOActualizar($alumno);      
        if (HttpMethod::POST == $method) {            
            return $this->generarRespuesta($alumno, Response::HTTP_OK, array('Default'));
        }
        return $this->generarRepuestaNotContent();
    }
    
    protected function obtenerAlumno($id) {
        $alumno = $this->getAlumnoService()->getById($id);
        if ($alumno == null) {
            $this->createNotFoundException("alumnoBundle.alumno.no_encontrado");
        }      
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        if ($usuario->getId() != $alumno->getUsuario()->getId()) {
            throw new AccessDeniedHttpException();
        }
        return $alumno;
    }
    
    private function getAlumnoService() {
        return $this->container->get('safe_alumno.service.alumno');
    }

}
