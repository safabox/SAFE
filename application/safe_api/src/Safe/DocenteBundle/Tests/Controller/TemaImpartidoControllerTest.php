<?php

namespace Safe\DocenteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class TemaImpartidoControllerTest extends SafeTestController {

    
    public function testGetAllAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $route =  $this->getUrl('api_1_docentes_cursos_temasget_docente_curso_temas', array('docenteId' => $id, 'cursoId' => $cursoId,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $temas = json_decode($response->getContent(), true);
        $this->assertCount(5, $temas);
        
        $tema = $temas[0];
        $this->assertCamposBasicos($tema);
        $this->assertArrayNotHasKey('predecesoras', $tema, 'No se debe mostrar las predecesoras en el listado');
        $this->assertArrayNotHasKey('sucesoras', $tema, 'No se debe mostrar las predecesoras en el listado');

    }
    
    public function testGetAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 2;
        $route =  $this->getUrl('api_1_docentes_cursos_temasget_docente_curso_tema', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $tema = json_decode($response->getContent(), true);
        $expectedTema = $this->getTema($temaId);
           
        $this->assertCamposBasicosEquals($expectedTema, $tema);
        
        $this->assertCount($expectedTema->getPredecesoras()->count(), $tema['predecesoras']);        
        $predecesora = $tema['predecesoras'][0];
        $expectedPredecesora = $expectedTema->getPredecesoras()->get(0);
        $this->assertCamposBasicosEquals($expectedPredecesora, $predecesora);
        
        $this->assertCount($expectedTema->getSucesoras()->count(), $tema['sucesoras']);       
        $sucesora = $tema['sucesoras'][0];
        $expectedSucesora = $expectedTema->getSucesoras()->get(0);
        $this->assertCamposBasicosEquals($expectedSucesora, $sucesora);                
    }
     
    public function testPostAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $nuevoTema = $this->crearTemaArray('Tema Test 1', 'copete 1','Descripcion Test 1', 1, array(1,2), array(3));
        $content = json_encode($nuevoTema);
        $route =  $this->getUrl('api_1_docentes_cursos_temaspost_docente_curso_tema', array('docenteId' => $id, 'cursoId' => $cursoId,'_format' => 'json'));
  
        //test
        $cliente->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $tema = json_decode($response->getContent(), true);
        
        $this->assertCamposBasicos($tema);
        
        $predecesora = $tema['predecesoras'][0];
        $expectedPredecesora = $this->getTema($nuevoTema['predecesoras'][0]);
        $this->assertCamposBasicosEquals($expectedPredecesora, $predecesora);
        
        $sucesora = $tema['sucesoras'][0];
        $expectedSucesora = $this->getTema($nuevoTema['sucesoras'][0]);
        $this->assertCamposBasicosEquals($expectedSucesora, $sucesora);
    }
    
    
    public function testPutAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        
        $temaDesactualizadoBBDD = $this->getTema($temaId);
        $temaAActualizar = $this->crearTemaArray($temaDesactualizadoBBDD->getTitulo().' PUT', $temaDesactualizadoBBDD->getCopete().' PUT',  $temaDesactualizadoBBDD->getDescripcion().' PUT', 1, array(3), array(2));        
        
        $content = json_encode($temaAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temasput_docente_curso_tema', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, '_format' => 'json'));
  
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $tema = $this->getTema($temaId);
        $this->assertEquals($temaAActualizar['titulo'], $tema->getTitulo());
        $this->assertEquals($temaAActualizar['descripcion'], $tema->getDescripcion());
        
        $this->assertEquals(1, $tema->getPredecesoras()->count());        
        $predecesora = $tema->getPredecesoras()->get(0);
        $expectedPredecesora = $this->getTema($temaAActualizar['predecesoras'][0]);
        $this->assertEquals($expectedPredecesora->getId(), $predecesora->getId());
                
        $this->assertEquals(1, $tema->getSucesoras()->count());
        $sucesora = $tema->getSucesoras()->get(0);
        $expectedSucesora = $this->getTema($temaAActualizar['sucesoras'][0]);
        $this->assertEquals($expectedSucesora->getId(), $sucesora->getId());
    }
    
    public function testPutAction_cambiarSucesorasYPredecesoras() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 3;
        
        $temaDesactualizadoBBDD = $this->getTema($temaId);
        $temaAActualizar = $this->crearTemaArray($temaDesactualizadoBBDD->getTitulo().' PUT', $temaDesactualizadoBBDD->getCopete().' PUT', $temaDesactualizadoBBDD->getDescripcion().' PUT', 1, array(4), array());        
        
        $content = json_encode($temaAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temasput_docente_curso_tema', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, '_format' => 'json'));
  
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $tema = $this->getTema($temaId);
        $this->assertEquals($temaAActualizar['titulo'], $tema->getTitulo());
        $this->assertEquals($temaAActualizar['descripcion'], $tema->getDescripcion());
        
        $this->assertEquals(1, $tema->getPredecesoras()->count());        
        $predecesora = $tema->getPredecesoras()->get(0);
        $expectedPredecesora = $this->getTema($temaAActualizar['predecesoras'][0]);
        $this->assertEquals($expectedPredecesora->getId(), $predecesora->getId());
                
        $this->assertEquals(0, $tema->getSucesoras()->count());
    }
    
    public function testPutAction_bajaLogica() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        
        
        $temaAActualizar = $this->crearTemaArray('Baja logica', 'Baja copete', 'Baja logica descripcoin', 1, array(), array());        
        $temaAActualizar['habilitado'] = false;
        
        $content = json_encode($temaAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temasput_docente_curso_tema', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, '_format' => 'json'));
  
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $tema = $this->getTema($temaId);
        $this->assertNotTrue($tema->isHabilitado());
    }
    
    
    
        
    private function assertCamposBasicosEquals($expectedTema, $tema) {
        $this->assertEquals($expectedTema->getId(), $tema['id']);
        $this->assertEquals($expectedTema->getTitulo(), $tema['titulo']);
        $this->assertEquals($expectedTema->getDescripcion(), $tema['descripcion']);
        $this->assertEquals($expectedTema->isHabilitado(), $tema['habilitado']);
        $this->assertEquals($expectedTema->getFechaModificacion()->format(DATE_ISO8601), $tema['fecha_modificacion']);
        $this->assertEquals($expectedTema->getFechaCreacion()->format(DATE_ISO8601), $tema['fecha_creacion']);        
        $this->assertEquals($expectedTema->getOrden(), $tema['orden']);       
    }
    
    private function assertCamposBasicos($tema){
        $this->assertArrayHasKey('id', $tema, 'id del tema no encontrado');
        $this->assertArrayHasKey('titulo', $tema, 'Titulo del tema no encontrado');
        $this->assertArrayHasKey('habilitado', $tema, 'Estado del tema no encontrada');
        $this->assertArrayHasKey('fecha_modificacion', $tema, 'Fecha de modificacion del tema no encontrada');
        $this->assertNotNull($tema['fecha_modificacion'], 'Fecha de modificacion del tema invalida');
        $this->assertArrayHasKey('fecha_creacion', $tema, 'Fecha de creacion del tema no encontrada');
        $this->assertNotNull($tema['fecha_creacion'], 'Fecha de creacion del tema invalida');        
    }
    
    protected function getTema($id) {
        $tema = $this->em
            ->getRepository('SafeTemaBundle:Tema')
            ->find($id)
        ;
        $this->em->detach($tema);
        return $tema;
    }
    
    protected function getCurso($id) {
        return $this->em
            ->getRepository('SafeCursoBundle:Curso')
            ->find($id)
        ;
    }
    
    protected function crearTemaArray($titulo, $copete, $descripcion, $orden, $predecesoras=array(), $sucesoras=array()) {        
        $dato = array(
            'titulo' => $titulo,
            'copete' => $copete,
            'descripcion' => $descripcion,
            'habilitado' => true,
            'orden' => $orden,
            'predecesoras' => $predecesoras,
            'sucesoras' => $sucesoras,
        );
        return $dato;
    }
    
}
