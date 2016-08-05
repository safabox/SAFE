<?php
namespace Safe\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Safe\CoreBundle\Http\HttpMethod;

use JMS\Serializer\SerializationContext;

use Doctrine\Common\Util\Debug;
abstract class SafeRestAbstractController extends FOSRestController {

    public function generarRespuesta($result, $responseStatusCode = Response::HTTP_OK, $groups = null) {        
        $view = $this->view($result, $responseStatusCode);
        if ($groups != null) {            
            $view->setSerializationContext(SerializationContext::create()->setGroups($groups));
        }                
        return $this->handleView($view);
    }
    
    public function generarRepuestaNotContent($statusCode = Response::HTTP_NO_CONTENT) {
        $response = new Response();
        $response->setStatusCode($statusCode);
        return $response;
    }
    
    
    public function procesarRequest(Request $request, $type, $data = null, $method = HttpMethod::POST) {
        
        //$form = $this->creatForm($type, $data, array('method' => $method));
        $form = $this->createForm($type, $data);
        try {            
            $form->submit($request->request->all(), HttpMethod::PATCH !== $method);         
            if ($form->isValid()) {                
                return $this->procesarEntidadValida($data, $method);                                    
            }
            return View::create($form->getErrors(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return View::create($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    protected abstract function procesarEntidadValida($data, $method = HttpMethod::POST);
    
}
