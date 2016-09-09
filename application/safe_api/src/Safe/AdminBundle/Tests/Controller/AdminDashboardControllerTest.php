<?php

namespace Safe\AdminBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class AdminDashboardControllerTest extends SafeTestController {

    public function testGetAction() {
        //inicio
        $clienteAdministrador = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_dashboardsget_dashboards', array('_format' => 'json'));
        
        //test
        $clienteAdministrador->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $clienteAdministrador->getResponse();
        $this->assertJsonResponse($response, 200);       
        $data = json_decode($response->getContent(), true);
        Debug::dump($data);
    }
        
    protected function getAlumno($id) {
        return $this->em
            ->getRepository('SafeAlumnoBundle:Alumno')
            ->find($id)
        ;
    }
    
    
    
}
