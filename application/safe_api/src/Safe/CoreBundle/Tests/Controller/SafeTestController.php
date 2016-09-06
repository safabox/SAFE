<?php

namespace Safe\CoreBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use Doctrine\Common\Util\Debug;

class SafeTestController extends WebTestCase {
    
    public function setUp(){
        //loadFixtures
        $fixtures = array(
                          'Safe\CoreBundle\DataFixtures\ORM\CoreData',
                          'Safe\InstitutoBundle\DataFixtures\ORM\InstitutoData', 
                          'Safe\AdminBundle\DataFixtures\ORM\AdminData',
                          'Safe\DocenteBundle\DataFixtures\ORM\DocenteData',
                          'Safe\CursoBundle\DataFixtures\ORM\CursoData'
            );
        $this->loadFixtures($fixtures);
    }

    protected function assertJsonResponse($response, $statusCode = 200) {
            $this->assertEquals(
                $statusCode, $response->getStatusCode(),
                $response->getContent()
            );
            $this->assertTrue(
                $response->headers->contains('Content-Type', 'application/json'),
                $response->headers
            );
    }
    
    protected function assertUsuarioAdminList($role='ROLE_USER', $usuario) {
        $this->assertArrayHasKey('id', $usuario, 'id del usuario no encontrado');
        $this->assertArrayHasKey('username', $usuario, 'Username no encontrado');
        $this->assertArrayHasKey('nombre', $usuario, 'Nombre del usuario no encontrado');
        $this->assertArrayHasKey('apellido', $usuario, 'Apellido del usuario no encontrado');
        $this->assertArrayHasKey('email', $usuario, 'Email del docente no encontrado');
        $this->assertArrayHasKey('enabled', $usuario, 'Habilitacion del usuario no encontrado');
        $this->assertArrayHasKey('locked', $usuario, 'Estado del bloqueo del usuario no encontrado');
        $this->assertArrayHasKey('last_login', $usuario, 'Ultimo ingreso del usuario no encontrado');
        $this->assertArrayHasKey('credentials_expired', $usuario, 'estado de las credenciales del usuario no encontrado');
        $this->assertArrayHasKey('credentials_expire_at', $usuario, 'proxima expiracion del usuario no encontrado');
        //$this->assertArrayHasKey('numero_documento', $usuario, 'numero de documento no encontrado');
        //$this->assertArrayHasKey('tipo_documento', $usuario, 'tipo de documento no encontrado');
        //$tipoDocumento = $usuario['tipo_documento'];
        //$this->assertArrayHasKey('codigo', $tipoDocumento, 'tipo de documento[codigo] no encontrado');

        $this->assertArrayHasKey('roles', $usuario, 'rol del usuario no encontrado');
        $roles = $usuario['roles'];
        $this->assertContains($role, $roles);
    }
    
    
    
    protected function createAdminClient($username = 'admin', $password='123456') {
        return $this->createAuthenticatedClient($username, $password);
    }

    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    
}
