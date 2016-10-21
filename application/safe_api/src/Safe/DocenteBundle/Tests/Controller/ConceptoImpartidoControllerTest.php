<?php

namespace Safe\DocenteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class ConceptoImpartidoControllerTest extends SafeTestController {

    
    public function testGetAllAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptosget_docente_curso_tema_conceptos', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $conceptos = json_decode($response->getContent(), true);
        $this->assertCount(5, $conceptos);
        
        $concepto = $conceptos[0];
        $this->assertCamposBasicos($concepto);
        $this->assertArrayNotHasKey('predecesoras', $concepto, 'No se debe mostrar las predecesoras en el listado');
        $this->assertArrayNotHasKey('sucesoras', $concepto, 'No se debe mostrar las predecesoras en el listado');

    }
    
    public function testGetAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 2;
        
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptosget_docente_curso_tema_concepto', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, 'conceptoId' => $conceptoId, '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $concepto = json_decode($response->getContent(), true);
        $expectedConcepto = $this->getConcepto($conceptoId);
           
        
        $this->assertCamposBasicosEquals($expectedConcepto, $concepto);
        
        $this->assertCount($expectedConcepto->getPredecesoras()->count(), $concepto['predecesoras']);        
        $predecesora = $concepto['predecesoras'][0];
        $expectedPredecesora = $expectedConcepto->getPredecesoras()->get(0);
        $this->assertCamposBasicosEquals($expectedPredecesora, $predecesora);
        
        $this->assertCount($expectedConcepto->getSucesoras()->count(), $concepto['sucesoras']);       
        $sucesora = $concepto['sucesoras'][0];
        $expectedSucesora = $expectedConcepto->getSucesoras()->get(0);
        $this->assertCamposBasicosEquals($expectedSucesora, $sucesora);                
    }
    
    public function testPostAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $nuevoConcepto = $this->crearConceptoArray('Tema Test 1', 'Descripcion Test 1', 1, array(1,2), array(3));
        $content = json_encode($nuevoConcepto);
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptospost_docente_curso_tema_concepto', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, '_format' => 'json'));
  
        //test
        $cliente->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $concepto = json_decode($response->getContent(), true);
        
        $this->assertCamposBasicos($concepto);
        
        $predecesora = $concepto['predecesoras'][0];
        $expectedPredecesora = $this->getConcepto($nuevoConcepto['predecesoras'][0]);
        $this->assertCamposBasicosEquals($expectedPredecesora, $predecesora);
        
        $sucesora = $concepto['sucesoras'][0];
        $expectedSucesora = $this->getConcepto($nuevoConcepto['sucesoras'][0]);
        $this->assertCamposBasicosEquals($expectedSucesora, $sucesora);
    }
    
    
    public function testPutAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1; 
        $conceptoId = 1;
        
        $conceptoDesactualizadoBBDD = $this->getConcepto($conceptoId);
        $conceptoAActualizar = $this->crearConceptoArray($conceptoDesactualizadoBBDD->getTitulo().' PUT', $conceptoDesactualizadoBBDD->getDescripcion().' PUT', 1, array(3), array(2));        
        
        $content = json_encode($conceptoAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptosput_docente_curso_tema_concepto', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, 'conceptoId' => $conceptoId, '_format' => 'json'));
  
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $concepto = $this->getConcepto($conceptoId);
        $this->assertEquals($conceptoAActualizar['titulo'], $concepto->getTitulo());
        $this->assertEquals($conceptoAActualizar['descripcion'], $concepto->getDescripcion());
        
        $this->assertEquals(1, $concepto->getPredecesoras()->count());        
        $predecesora = $concepto->getPredecesoras()->get(0);
        $expectedPredecesora = $this->getConcepto($conceptoAActualizar['predecesoras'][0]);
        $this->assertEquals($expectedPredecesora->getId(), $predecesora->getId());
                
        $this->assertEquals(1, $concepto->getSucesoras()->count());
        $sucesora = $concepto->getSucesoras()->get(0);
        $expectedSucesora = $this->getConcepto($conceptoAActualizar['sucesoras'][0]);
        $this->assertEquals($expectedSucesora->getId(), $sucesora->getId());
    }
    
    public function testPutAction_cambiarSucesorasYPredecesoras() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 3;
        
        $conceptoDesactualizadoBBDD = $this->getConcepto($conceptoId);
        $conceptoAActualizar = $this->crearConceptoArray($conceptoDesactualizadoBBDD->getTitulo().' PUT', $conceptoDesactualizadoBBDD->getDescripcion().' PUT', 1, array(4), array());        
        
        $content = json_encode($conceptoAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptosput_docente_curso_tema_concepto', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, 'conceptoId' => $conceptoId, '_format' => 'json'));
  
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $concepto = $this->getConcepto($conceptoId);
        $this->assertEquals($conceptoAActualizar['titulo'], $concepto->getTitulo());
        $this->assertEquals($conceptoAActualizar['descripcion'], $concepto->getDescripcion());
        
        $this->assertEquals(1, $concepto->getPredecesoras()->count());        
        $predecesora = $concepto->getPredecesoras()->get(0);
        $expectedPredecesora = $this->getConcepto($conceptoAActualizar['predecesoras'][0]);
        $this->assertEquals($expectedPredecesora->getId(), $predecesora->getId());
                
        $this->assertEquals(0, $concepto->getSucesoras()->count());
    }
    
    public function testPutAction_bajaLogica() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 1;
        
        
        $conceptoAActualizar = $this->crearConceptoArray('Baja logica', 'Baja logica descripcoin', 1, array(), array());        
        $conceptoAActualizar['habilitado'] = false;
        
        $content = json_encode($conceptoAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptosput_docente_curso_tema_concepto', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, 'conceptoId' => $conceptoId, '_format' => 'json'));
  
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $concepto = $this->getConcepto($conceptoId);
        $this->assertNotTrue($concepto->isHabilitado());
    }
    
    
        
    private function assertCamposBasicosEquals($expectedConcepto, $concepto) {
        $this->assertEquals($expectedConcepto->getId(), $concepto['id']);
        $this->assertEquals($expectedConcepto->getTitulo(), $concepto['titulo']);
        $this->assertEquals($expectedConcepto->getDescripcion(), $concepto['descripcion']);
        $this->assertEquals($expectedConcepto->isHabilitado(), $concepto['habilitado']);
        $this->assertEquals($expectedConcepto->getFechaModificacion()->format(DATE_ISO8601), $concepto['fecha_modificacion']);
        $this->assertEquals($expectedConcepto->getFechaCreacion()->format(DATE_ISO8601), $concepto['fecha_creacion']);        
        $this->assertEquals($expectedConcepto->getOrden(), $concepto['orden']);       
    }
    
    private function assertCamposBasicos($concepto){
        $this->assertArrayHasKey('id', $concepto, 'id del tema no encontrado');
        $this->assertArrayHasKey('titulo', $concepto, 'Titulo del tema no encontrado');
        $this->assertArrayHasKey('habilitado', $concepto, 'Estado del tema no encontrada');
        $this->assertArrayHasKey('fecha_modificacion', $concepto, 'Fecha de modificacion del tema no encontrada');
        $this->assertNotNull($concepto['fecha_modificacion'], 'Fecha de modificacion del tema invalida');
        $this->assertArrayHasKey('fecha_creacion', $concepto, 'Fecha de creacion del tema no encontrada');
        $this->assertNotNull($concepto['fecha_creacion'], 'Fecha de creacion del tema invalida');        
    }
    
    protected function getConcepto($id) {
        $concepto =  $this->em
            ->getRepository('SafeTemaBundle:Concepto')
            ->find($id)
        ;
        $this->em->detach($concepto);
        return $concepto;
    }
    
    
    protected function crearConceptoArray($titulo, $descripcion, $orden, $predecesoras=array(), $sucesoras=array()) {        
        $dato = array(
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'habilitado' => true,
            'orden' => $orden,
            'predecesoras' => $predecesoras,
            'sucesoras' => $sucesoras,
        );
        return $dato;
    }
    
}
