<?php
namespace Safe\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;

use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\AdminBundle\Form\RegistracionAlumnoType;
use Safe\AdminBundle\Form\RegistracionAlumnoPatchType;
use Safe\AlumnoBundle\Entity\Alumno;

use Doctrine\Common\Util\Debug;

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
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('listado', 'admin_listado')));
        return $this->handleView($view);
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
     *     200 = "Usuario creado correctamente",
     *     400 = "Hubo un error al crear el usuario"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postAlumnoAction(Request $request) {
        try {
            $alumno = new Alumno();
            $form = $this->createForm(new RegistracionAlumnoType(), $alumno);
            $form->submit($request);                 
            if ($form->isValid()) {
                $this->getAlumnoService()->crear($alumno);
                return $alumno;    
            }
            return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
            return View::create($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
     *     200 = "Usuario creado correctamente",
     *     400 = "Hubo un error al crear el usuario"
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
        try {                        
            $form = $this->createForm(new RegistracionAlumnoType(), $alumno);
            $form->submit($request);                 
            if ($form->isValid()) {                      
                $this->getAlumnoService()->crear($alumno);
                return $alumno;    
            }
            return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {            
            return View::create($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
     *     200 = "Usuario creado correctamente",
     *     400 = "Hubo un error al crear el usuario"
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
        try {                                    
            $form = $this->createForm(new RegistracionAlumnoType(), $alumno);            
            $form->submit($request->request->all(), false);                       
            if ($form->isValid()) {                
                $this->getAlumnoService()->crearOActualizar($alumno);
                return $alumno;    
            }
            return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {            
            return View::create($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        
        $view = $this->view($this->getAlumnoService()->getById($id), Response::HTTP_OK);
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('detalle')));
       
        return $this->handleView($view);
    } 
    
    
    
    
    private function getAlumnoService() {
        return $this->container->get('safe_alumno.service.alumno');
    }
}
