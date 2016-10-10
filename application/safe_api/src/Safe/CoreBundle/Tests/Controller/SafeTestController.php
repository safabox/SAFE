<?php

namespace Safe\CoreBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use Doctrine\Common\Util\Debug;

class SafeTestController extends WebTestCase {
    
    protected $em;
    
    public function setUp(){
        self::bootKernel();
        //loadFixtures
        $fixtures = array(
                          'Safe\CoreBundle\DataFixtures\ORM\CoreData',
                          'Safe\InstitutoBundle\DataFixtures\ORM\InstitutoData', 
                          'Safe\AdminBundle\DataFixtures\ORM\AdminData',
                          'Safe\DocenteBundle\DataFixtures\ORM\DocenteData',
                          'Safe\AlumnoBundle\DataFixtures\ORM\AlumnoData',
                          'Safe\CursoBundle\DataFixtures\ORM\CursoData',
                          'Safe\CatBundle\DataFixtures\ORM\CATData',
                          
            );
        $this->loadFixtures($fixtures);
        
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
        $this->em = null; // avoid memory leaks
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
    
    protected function assertUsuarioAdminList($usuario, $role='ROLE_USER') {
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
    
    protected function assertUsuarioList($usuario, $role='ROLE_USER') {
        $this->assertArrayHasKey('id', $usuario, 'id del usuario no encontrado');
        $this->assertArrayHasKey('username', $usuario, 'Username no encontrado');
        $this->assertArrayHasKey('nombre', $usuario, 'Nombre del usuario no encontrado');
        $this->assertArrayHasKey('apellido', $usuario, 'Apellido del usuario no encontrado');
        $this->assertArrayHasKey('email', $usuario, 'Email del docente no encontrado');
        $this->assertArrayHasKey('last_login', $usuario, 'Ultimo ingreso no encontrado');
        $this->assertArrayHasKey('enabled', $usuario, 'Habilitacion no encontrado');
        
        $this->assertArrayNotHasKey('locked', $usuario, 'Estado del bloqueo no ocultado');
        $this->assertArrayNotHasKey('credentials_expired', $usuario, 'estado de las credenciales del usuario no ocultado');
        $this->assertArrayNotHasKey('credentials_expire_at', $usuario, 'proxima expiracion del usuario no ocultado');
        //$this->assertArrayHasKey('numero_documento', $usuario, 'numero de documento no encontrado');
        //$this->assertArrayHasKey('tipo_documento', $usuario, 'tipo de documento no encontrado');
        //$tipoDocumento = $usuario['tipo_documento'];
        //$this->assertArrayHasKey('codigo', $tipoDocumento, 'tipo de documento[codigo] no encontrado');

        $this->assertArrayHasKey('roles', $usuario, 'rol del usuario no ocultado');
        $roles = $usuario['roles'];
        $this->assertContains($role, $roles);
    }
    
    
    
    protected function createClienteAdministrador($username = 'admin', $password='123456') {
        $login = $this->crearClienteAutenticado($username, $password);
        return $login['cliente'];
    }
    
    protected function loginAlumno($username = 'alumno1', $password='123456') {
        $login = $this->crearClienteAutenticado($username, $password);                
        return $login;
    }
    
    protected function loginDocente($username = 'docente1', $password='123456') {
        $login = $this->crearClienteAutenticado($username, $password);
        return $login;
    }

    protected function crearClienteAutenticado($username = 'user', $password = 'password')
    {
        $cliente = static::createClient();
        $cliente->request(
            'POST',
            '/api/login_check',
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );

        $data = json_decode($cliente->getResponse()->getContent(), true);        
        $cliente = static::createClient();
        $cliente->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
        
        $resultado = array('cliente' => $cliente, 'datos' => $data);
        return $resultado;
    }

    
}
