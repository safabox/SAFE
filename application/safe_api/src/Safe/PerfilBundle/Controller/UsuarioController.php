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

//http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
class UsuarioController extends FOSRestController {
    /**
     * Lista todos los usuarios
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Numero de pagina.")
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
     * Obtiene un usuario,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtiene el usuario segun el  id",
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
    public function getUsuarioAction($id)
    {
        
        //$view = $this->view();
        //$view->setSerializationContext(SerializationContext::create()->setGroups(array('alumno_detalle')));
       
        return $this->getUsuarioService()->getById($id);
    } 
    
    /**
     * Crea un nuevo usuario.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "PerfilBundle\Form\UsuarioType",
     *   statusCodes = {
     *     200 = "Usuario creado correctamente",
     *     400 = "Hubo un error al crear el usuario"
     *   }
     * )
     *
     * @param Request $request the request object
     *     
     */
    public function postUsersAction(Request $request) {
        $usuario = new Usuario();
        $form = $this->createForm(new UsuarioType(), $usuario);
        $form->submit($request);
        if ($form->isValid()) {            
            $this->getUsuarioService()->save($usuario);
            return $usuario;    
        }
        return View::create($form->getErrors(), 400);
    }

    
    
    private function getUsuarioService() {
        return $this->container->get('safe_perfil.service.usuario');
    }
}
