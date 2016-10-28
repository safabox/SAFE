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
        
        $this->assertArrayHasKey('cursos_totales', $data, 'cantidad de cursos no encontrado');
        $this->assertTrue($data['cursos_totales'] > 0, 'cantidad de cursos totales invalida');
                
        $this->assertArrayHasKey('docentes_totales', $data, 'cantidad de docentes no encontrado');
        $this->assertTrue($data['docentes_totales'] > 0, 'cantidad de docentes totales invalida');
        
        $this->assertArrayHasKey('alumnos_totales', $data, 'cantidad de alumnos no encontrado');
        $this->assertTrue($data['alumnos_totales'] > 0, 'cantidad de alumnos totales invalida');
    }
        
    protected function getAlumno($id) {
        return $this->em
            ->getRepository('SafeAlumnoBundle:Alumno')
            ->find($id)
        ;
    }
    
    
    
}
