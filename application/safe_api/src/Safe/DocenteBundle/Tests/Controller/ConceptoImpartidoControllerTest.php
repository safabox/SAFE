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

        $this->assertArrayNotHasKey('tipo', $concepto, 'No se debe mostrar el tipo en el listado');    
        $this->assertArrayNotHasKey('rango', $concepto, 'No se debe mostrar el rango en el listado');
        $this->assertArrayNotHasKey('metodo', $concepto, 'No se debe mostrar el metodo en el listado');
        $this->assertArrayNotHasKey('incremento', $concepto, 'No se debe mostrar el incremento en el listado');

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
        
//        $this->assertCount($expectedConcepto->getSucesoras()->count(), $concepto['sucesoras']);       
//        $sucesora = $concepto['sucesoras'][0];
//        $expectedSucesora = $expectedConcepto->getSucesoras()->get(0);
//        $this->assertCamposBasicosEquals($expectedSucesora, $sucesora);                
        $this->assertEquals('2PL', $concepto['tipo']);
        $this->assertSame(array(-2, 3), $concepto['rango']);
        $this->assertEquals('THETA_MLE', $concepto['metodo']);
        $this->assertEquals(0.1, $concepto['incremento'],'', 0.1);
    }
    
    public function testPostAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $nuevoConcepto = $this->crearConceptoArray('Tema Test 1', 'copete 1','Descripcion Test 1', 1, array(1,2), array(3));
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
        
//        $sucesora = $concepto['sucesoras'][0];
//        $expectedSucesora = $this->getConcepto($nuevoConcepto['sucesoras'][0]);
//        $this->assertCamposBasicosEquals($expectedSucesora, $sucesora);

        $this->assertEquals('2PL', $concepto['tipo']);
        $this->assertSame(array(-1, 1), $concepto['rango']);
        $this->assertEquals('THETA_MLE', $concepto['metodo']);
        $this->assertEquals(0.1, $concepto['incremento'],'', 0.1);

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
        $conceptoAActualizar = $this->crearConceptoArray($conceptoDesactualizadoBBDD->getTitulo().' PUT', $conceptoDesactualizadoBBDD->getCopete().' PUT',$conceptoDesactualizadoBBDD->getDescripcion().' PUT', 1, array(3), array(2));        
        $conceptoAActualizar['tipo'] = 'RASH';
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
                
//        $this->assertEquals(1, $concepto->getSucesoras()->count());
//        $sucesora = $concepto->getSucesoras()->get(0);
//        $expectedSucesora = $this->getConcepto($conceptoAActualizar['sucesoras'][0]);
//        $this->assertEquals($expectedSucesora->getId(), $sucesora->getId());
        
        $itemBank = $this->getItemBank($concepto->getId());
        $this->assertEquals('RASH', $itemBank->getItemType());
   
    }

    public function testPutAction_cambiarPredecesoras() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 3;
        
        $conceptoDesactualizadoBBDD = $this->getConcepto($conceptoId);
        $conceptoAActualizar = $this->crearConceptoArray($conceptoDesactualizadoBBDD->getTitulo().' PUT', $conceptoDesactualizadoBBDD->getCopete(),$conceptoDesactualizadoBBDD->getDescripcion().' PUT', 1, array(4), array());        
        
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
                
        $conceptoSucesoraId = 4;
        $conceptoSucesora = $this->getConcepto($conceptoSucesoraId);
        $this->assertEquals(2, $conceptoSucesora->getPredecesoras()->count());        
        $this->assertExisteConcepto($concepto, $conceptoSucesora->getPredecesoras());   
    }
    
    public function testPutAction_bajaLogica() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 1;
        
        
        $conceptoAActualizar = $this->crearConceptoArray('Baja logica', 'baja copete','Baja logica descripcoin', 1, array(), array());        
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
    
    public function testPatchAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 3;
        
        $conceptoDesactualizadoBBDD = $this->getConcepto($conceptoId);
        $conceptoAActualizar = array(
            'titulo' => $conceptoDesactualizadoBBDD->getTitulo().' PATCH',
            'habilitado' => 'true'
        );
        $content = json_encode($conceptoAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptospatch_docente_curso_tema_concepto', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, 'conceptoId' => $conceptoId, '_format' => 'json'));
  
        //test
        $cliente->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $concepto = $this->getConcepto($conceptoId);
        $this->assertEquals($conceptoAActualizar['titulo'], $concepto->getTitulo());
        $this->assertEquals($conceptoDesactualizadoBBDD->getDescripcion(), $concepto->getDescripcion());
        $this->assertTrue($concepto->isHabilitado());
    }

    public function testPatchAction_cambiarPredesoras() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 3;
        
        $conceptoDesactualizadoBBDD = $this->getConcepto($conceptoId);
        $conceptoAActualizar = array(
            'predecesoras' => array(4)
        );
        $content = json_encode($conceptoAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptospatch_docente_curso_tema_concepto', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, 'conceptoId' => $conceptoId, '_format' => 'json'));
  
        //test
        $cliente->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $concepto = $this->getConcepto($conceptoId);
       
        $this->assertEquals(1, $concepto->getPredecesoras()->count());        
        $predecesora = $concepto->getPredecesoras()->get(0);
        $expectedPredecesora = $this->getConcepto($conceptoAActualizar['predecesoras'][0]);
        $this->assertEquals($expectedPredecesora->getId(), $predecesora->getId());
                
        $conceptoSucesoraId = 4;
        $conceptoSucesora = $this->getConcepto($conceptoSucesoraId);
        $this->assertEquals(2, $conceptoSucesora->getPredecesoras()->count());        
        $this->assertExisteConcepto($concepto, $conceptoSucesora->getPredecesoras()); 
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
    
    private function assertExisteConcepto($conceptoEsperado, $array) {
        foreach ($array as $concepto) {
            if ($concepto->getId() == $conceptoEsperado->getId()) {
                return;
            }
        }
        $this->assertTrue(false, 'No se encontro el tema');
    }
    
    protected function getConcepto($id) {
        $concepto =  $this->em
            ->getRepository('SafeTemaBundle:Concepto')
            ->find($id)
        ;
        $this->em->detach($concepto);
        return $concepto;
    }
    
    protected function getItemBank($code) {
        $itemBank =  $this->em
            ->getRepository('SafeCatBundle:ItemBank')
            ->findOneBy(array('code'=>$code))
        ;
        $this->em->detach($itemBank);
        return $itemBank;
    }
    
    
    protected function crearConceptoArray($titulo, $copete, $descripcion, $orden, $predecesoras=array(), $sucesoras=array()) {        
        $dato = array(
            'titulo' => $titulo,
            'copete' => $copete,
            'descripcion' => $descripcion,
            'habilitado' => true,
            'orden' => $orden,
            'predecesoras' => $predecesoras,
            'sucesoras' => $sucesoras,
            'tipo' => '2PL',
            'rango' => array(-1, 1),
            'metodo' => 'THETA_MLE',
            'incremento' => 0.1,
        );
        return $dato;
    }
    
}
