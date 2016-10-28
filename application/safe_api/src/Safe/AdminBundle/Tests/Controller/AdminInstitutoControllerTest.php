<?php

namespace Safe\AdminBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class AdminInstitutoControllerTest extends SafeTestController {

    public function testAllAction() {
        $adminClient = $this->createClienteAdministrador();                
        $route =  $this->getUrl('api_1_admin_institutosget_instituto', array('_format' => 'json'));

        
        $adminClient->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        $response = $adminClient->getResponse();
        $content = $response->getContent();
        $this->assertJsonResponse($response, 200);
        $this->assertEquals('{"id":1,"razon_social":"Instituto Test","descripcion":"descripcion test"}', $content);
        
    }
    
}
