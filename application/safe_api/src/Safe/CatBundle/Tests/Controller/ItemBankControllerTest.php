<?php

namespace Safe\CatBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class ItemBankControllerTest extends SafeTestController {

    public function testGetAllAction() {
        //inicio
        $cliente = static::createClient();
                    
        $route =  $this->getUrl('api_1_item_banksget_item_banks', array('_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $data = json_decode($response->getContent(), true);
        $this->assertTrue(count($data) > 0);
        
        $itemBank = $data[0];
        $this->assertNotNull($itemBank['id'], $itemBank, 'id del itemBank no encontrado');
        $this->assertNotNull($itemBank['code'], $itemBank, 'code del itemBank no encontrado');        
        $this->assertNotNull($itemBank['item_type'], $itemBank, 'item_type del itemBank no encontrado');
        $this->assertNotNull($itemBank['created'], $itemBank, 'created del itemBank no encontrado');
        $this->assertNotNull($itemBank['updated'], $itemBank, 'updated del itemBank no encontrado');
        $this->assertNotNull($itemBank['items'], $itemBank, 'items del itemBank no encontrado');
        $this->assertNotNull($itemBank['abilities'], $itemBank, 'abilities del itemBank no encontrado');
    }   
}
