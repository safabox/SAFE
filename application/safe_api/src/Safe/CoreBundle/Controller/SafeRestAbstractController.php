<?php
namespace Safe\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Safe\CoreBundle\Http\HttpMethod;

use JMS\Serializer\SerializationContext;

use Symfony\Component\Translation\Translator;

use Doctrine\Common\Util\Debug;
abstract class SafeRestAbstractController extends FOSRestController {

    
    
    public function generarRespuesta($result, $responseStatusCode = Response::HTTP_OK, $groups = null) {        
        $view = $this->view($result, $responseStatusCode);
        if ($groups != null) {            
            $view->setSerializationContext(SerializationContext::create()->setGroups($groups)->enableMaxDepthChecks());
        }                
        return $this->handleView($view);
    }
    
    public function generarRepuestaNotContent() {
        return $this->crearResponse(Response::HTTP_NO_CONTENT);
    }
    
    public function generarRepuestaBadRequest($content = 'Bad Request') {
        return $this->crearResponse($statusCode = Response::HTTP_BAD_REQUEST, $content);
    }
    
    public function generarRepuestaNotFount($content = 'Entidad no encontrada') {
        return $this->crearResponse(Response::HTTP_NOT_FOUND, $content);
    }
    
    public function crearResponse($statusCode = Response::HTTP_ACCEPTED, $content = '') {
        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->setContent($content);
        return $response;
    }
    public function procesarRequest(Request $request, $type, $data = null, $method = HttpMethod::POST, $patchLimpiarAtributos = []) {
        
        //$form = $this->creatForm($type, $data, array('method' => $method));
        $form = $this->createForm($type, $data);
        try {   
            $datoRequest = $request->request->all();
            if (HttpMethod::PATCH === $method) {    
                $reflection = new \ReflectionClass($data);
                foreach ($patchLimpiarAtributos as $atributo) {
                    if (array_key_exists($atributo, $datoRequest)) {                        
                        $nombreMetodo = 'get'. ucfirst($atributo);
                        if ($reflection->hasMethod($nombreMetodo)) {   
                            $metodo = $reflection->getMethod($nombreMetodo);
                            $listado =$metodo->invoke($data);                                                        
                            $listado->clear(); 
                        }
                    }
                }
            }   
            $form->submit($datoRequest, HttpMethod::PATCH !== $method);         
            if ($form->isValid()) {                                       
                return $this->procesarEntidadValida($data, $method);                                    
            }
            return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return View::create($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function obtenerIdentificadorPostRequest(Request $request) {
         $form = $this->createFormBuilder()
                        ->add('id', 'number')
                        ->getForm();
         $form->submit($request->request->all());         
         return $form->getData()['id'];
    }
    
    public function traducir($mensaje) {
        return $this->container->get('translator')->trans($mensaje);
    } 
    
    public function obtenerInstitutoPorDefecto() {
        $instituto = $this->container->get('safe_instituto.service.instituto')->obtenerInstitutoPorDefecto();
                
        if ($instituto == null) {        
            throw  $this->createNotFoundException($this->traducir("institutoBundle.instituto.no_encontrado"));
        }         
        return $instituto;
    }
    
    protected abstract function procesarEntidadValida($data, $method = HttpMethod::POST);
    
}
