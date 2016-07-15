<?php
namespace Safe\PerfilBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use JMS\Serializer\SerializationContext;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Safe\PerfilBundle\Entity\Usuario;
use Safe\PerfilBundle\Form\UsuarioType;

use Safe\PerfilBundle\Form\RegistracionUsuarioType;
use Safe\PerfilBundle\Form\Model\RegistracionUsuario;

//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class UsuarioController extends FOSRestController {
    /**
     * Listado de usuarios disponibles en el sistema.
     *
     * @ApiDoc(     
     *   resource = true,
     *   output="array<Safe\PerfilBundle\Entity\Usuario>",
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
    public function getUsuariosAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        
        //$view = $this->view();
        //$view->setSerializationContext(SerializationContext::create()->setGroups(array('alumno_listado')));
       
        return $this->getUsuarioService()->findAll($limit, $offset);
    } 
    
    
    /**
     * Crea un nuevo usuario
     * 
     * #### Ejemplo del Request
     * **Registrar un usuario del tipo alumno y docente**
     * ```
     * {
     *  "usuario": {
     *      "nombre": "Juan",
     *      "apellido": "Perez",
     *      "username": "juancito",
     *      "email": "juan.perez@organizacion.org",
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      },
     *      "roles" : ["ROLE_ALUMNO", "ROLE_DOCENTE"]
     *	},
     *	"alumno": {
     *      "legajo":  "123456"
     *  },
     *	"docente": {
     *      "curriculum":  "este es el curriculumn del profesor"
     *  }
     * } 
     * ```
     * **Registrar un usuario del tipo docente**
     * ```
     * {
     *  "usuario": {
     *      "nombre": "Ruben",
     *      "apellido": "Aguirre",
     *      "username": "Jirafales",
     *      "email": "jirafales@organizacion.org",
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      },
     *      "roles" : ["ROLE_DOCENTE"]
     *	},
     *  "docente": {
     *      "curriculum":  "este es el curriculumn del profesor"
     *  }
     * } 
     * ```
     * **Registrar un usuario del tipo alumno**
     * ```
     * {
     *  "usuario": {
     *      "nombre": "Roberto",
     *      "apellido": "Gómez Bolaño",
     *      "username": "chespirito",
     *      "email": "chespirito@organizacion.org",
     *      "plainPassword": {
     *          "first" : "123456",
     *          "second" : "123456"
     *      },
     *      "roles" : ["ROLE_ALUMNO"]
     *	},
     *	"alumno": {
     *      "legajo":  "123457"
     *  }
     * } 
     * ```
     * @ApiDoc(          
     *   input = "Safe\PerfilBundle\Form\RegistracionUsuarioType",
     *   output="Safe\PerfilBundle\Form\Model\RegistracionUsuario",
     *   statusCodes = {
     *     200 = "Usuario creado correctamente",
     *     400 = "Hubo un error al crear el usuario"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postUsuarioAction(Request $request) {
        try {
            $registracionUsuario = new RegistracionUsuario();
            $form = $this->createForm(new RegistracionUsuarioType(), $registracionUsuario);
            $form->submit($request);        
            if ($form->isValid()) {       
                    $registracionUsuario->limpiarEntidadesSinRol();
                    $usuario = $registracionUsuario->getUsuario();
                    $docente = $registracionUsuario->getDocente();
                    $alumno = $registracionUsuario->getAlumno();                    
                    $this->getUsuarioService()->registrarUsuario($usuario, $docente, $alumno);
                    return $registracionUsuario;    
            }
            return View::create($form->getErrors(), 400);
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
            return View::create($ex->getMessage(), 500);
        }
    }

    /**     
     * Obtiene el usuario segun el  id
     * @ApiDoc(
     *   output = "Safe\PerfilBundle\Entity\Usuario",
     *   statusCodes = {
     *     200 = "Petición resuelta correctamente",
     *     404 = "Usuario no encontrado"
     *   }
     * )
     *
     * @Annotations\View(templateVar="page")
     *
     * @param int     $id      id del alumno.
     *
     * @return object
     *
     * @throws NotFoundHttpException cuando no existe el usuario.
     */
    public function getUsuarioAction($id)
    {
        
        //$view = $this->view();
        //$view->setSerializationContext(SerializationContext::create()->setGroups(array('alumno_detalle')));
       
        return $this->getUsuarioService()->getById($id);
    } 
    
    private function getUsuarioService() {
        return $this->container->get('safe_perfil.service.usuario');
    }
}
