<?php

namespace Safe\DocenteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class DocenteControllerTest extends SafeTestController {

    
    public function testGetAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $route =  $this->getUrl('api_1_docentesget_docente', array('id' => $id, '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $docente = json_decode($response->getContent(), true);
        
        $this->assertArrayHasKey('id', $docente, 'id del docente no encontrado');
        $this->assertArrayHasKey('legajo', $docente, 'Legajo del docente no encontrado');
        $this->assertArrayHasKey('fecha_creacion', $docente, 'Fecha de creacion del docente no encontrada');
        $this->assertNotNull($docente['fecha_creacion'], 'Fecha de creacion del docente invalida');
        $this->assertArrayHasKey('fecha_modificacion', $docente, 'Fecha de modifiacion del docente no encontrada');
        $this->assertNotNull($docente['fecha_modificacion'], 'Fecha de modifiacion del docente invalida');
        
        $this->assertArrayHasKey('usuario', $docente, 'Datos del usuario del docente no encontrado');        
        $usuario = $docente['usuario'];
        
        $this->assertUsuarioList($usuario, 'ROLE_DOCENTE');        
        //datos para el detalle
        $this->assertArrayHasKey('curriculum', $docente, 'curriculum del docente no encontrado');
        $this->assertArrayHasKey('cursos', $docente, 'cursos del docente no encontrado');
        $cursos = $docente['cursos'];
        $this->assertNotEmpty($cursos);
        $curso = $cursos[0];
        $this->assertArrayHasKey('id', $curso, 'Id del curso no encontrado');
        $this->assertArrayHasKey('titulo', $curso, 'titulo del curso no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $curso, 'fecha de modificacion del curso no encontrado');
        $this->assertNotNull($curso['fecha_modificacion'], 'Fecha de modifiacion del curso invalida');
        $this->assertArrayHasKey('fecha_creacion', $curso, 'fecha de creacion del curso no encontrado');
        $this->assertNotNull($curso['fecha_creacion'], 'Fecha de creacion del curso invalida');
        
        $this->assertArrayHasKey('numero_documento', $usuario, 'numero de documento no encontrado');
        $this->assertArrayHasKey('tipo_documento', $usuario, 'tipo de documento no encontrado');
        $tipoDocumento = $usuario['tipo_documento'];
        $this->assertArrayHasKey('codigo', $tipoDocumento, 'tipo de documento[codigo] no encontrado');

    }
    
       public function testGetAction_conIdUsuarioDiferenteAlLogueado_retornaStatusForbidden() {
        //inicio
        $login = $this->loginDocente();  
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'] + 1;
        $route =  $this->getUrl('api_1_docentesget_docente', array('id' => $id, '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 403);       
        
    }
    
    public function testPutAction() {
        //inicio        
        $nuevoCurriculum = 'test put';
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        
        $route =  $this->getUrl('api_1_docentesput_docente', array('id' => $id, '_format' => 'json'));       
        $docente = $this->crearDocenteArray('docente1', '1');
        $docente['curriculum'] = $nuevoCurriculum;
        
        
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($docente));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
        $docente = $this->getDocente($id);
        $this->assertEquals($nuevoCurriculum, $docente->getCurriculum());        
    }
    public function testPutAction_conIdUsuarioDiferenteAlLogueado_retornaStatusForbidden() {
        //inicio        
        $nuevoCurriculum = 'test put';
        $login = $this->loginDocente();       
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'] + 1;
        $route =  $this->getUrl('api_1_docentesput_docente', array('id' => $id, '_format' => 'json'));       
        $docente = $this->crearDocenteArray('docente1', '1');
        $docente['curriculum'] = $nuevoCurriculum;
        
        
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($docente));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(403, $response->getStatusCode(), 'Se esperaba status code 403 en vez de '.$response->getStatusCode());

    }
    
    public function testPatchAction() {
        //inicio        
        $nuevoCurriculum = 'test patch';
        $login = $this->loginDocente();  
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        
        $route =  $this->getUrl('api_1_docentespatch_docente', array('id' => $id, '_format' => 'json'));       
        $docente = array('curriculum' => $nuevoCurriculum);
        
        
        //test
        $cliente->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($docente));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        
        $docente = $this->getDocente($id);
        $this->assertEquals($nuevoCurriculum, $docente->getCurriculum());
    }
    
    public function testPatchAction_conIdUsuarioDiferenteAlLogueado_retornaStatusForbidden() {
        //inicio        
        $nuevoCurriculum = 'test patch';
        $login = $this->loginDocente();   
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'] + 1;
        $route =  $this->getUrl('api_1_docentespatch_docente', array('id' => $id, '_format' => 'json'));       
        $docente = array('curriculum' => $nuevoCurriculum);
        
        
        //test
        $cliente->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), json_encode($docente));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(403, $response->getStatusCode(), 'Se esperaba status code 403 en vez de '.$response->getStatusCode());
        
    }
    
    protected function crearDocenteArray($username, $legajo, $curriculum = '<h3>Educaci&oacute;n<h3>') {
        $dato = array(
            'legajo' => $legajo,
            'curriculum' => $curriculum,
            'usuario' => array(
                'nombre'=> $username.'_nombre',
                'apellido'=> $username.'_apellido',
                'username'=> $username,
                'tipoDocumento'=>  'DNI',
                'numeroDocumento'=> $legajo,
                'genero'=> 'Masculino',
                'email'=> $username.'@mail.org',
                'enabled'=> 'true',
                'textPassword' => array(
                    'first'=> '123456',
                    'second'=> '123456',
                )
            )
        );
        return $dato;
    }
    
    protected function getDocente($id) {
        return $this->em
            ->getRepository('SafeDocenteBundle:Docente')
            ->find($id)
        ;
    }
    
    
    
}
