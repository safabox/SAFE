<?php

namespace Safe\DocenteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
use Safe\TemaBundle\Entity\Tema;
use Safe\TemaBundle\Entity\Concepto;
use Safe\CatBundle\Entity\ItemBank;
class AlumnoAsignadoControllerTest extends SafeTestController {

   
    public function testGetAlumnoEstadisticaAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $curso = $this->getCursoByTitulo('Estadistica 1');
        $cursoId = $curso->getId();
        $alumnoEsperado = $this->getAlumnoByLegajo('1000');
        $alumnoId = $alumnoEsperado->getId();
        $route =  $this->getUrl('api_1_docentes_cursos_alumnosget_docente_curso_alumno_estadistica', array('docenteId' => $id, 'cursoId' => $cursoId, 'alumnoId' => $alumnoId,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $alumno = json_decode($response->getContent(), true);

        $this->assertEquals($alumnoEsperado->getId(), $alumno['id']);
        $this->assertEquals($alumnoEsperado->getUsuario()->getNombre(), $alumno['nombre']);
        $this->assertEquals($alumnoEsperado->getLegajo(), $alumno['legajo']);
        
        $this->assertArrayHasKey('temas', $alumno); 
        $this->assertEquals(2, count($alumno['temas']));
        $tema = $this->getElementFromArrayByTitulo('1000 tema', $alumno['temas']);
        $this->assertNotNull($tema);                
        $temaEsperado = $this->getTemaByTitulo('1000 tema');
        
        
        $this->assertEquals($temaEsperado->getId(), $tema['id']);
        $this->assertEquals($temaEsperado->getTitulo(), $tema['titulo']);
        $this->assertEquals($temaEsperado->getOrden(), $tema['orden']);
        $this->assertEquals(ResultadoEvaluacion::FINALIZADO, $tema['estado']);
        $this->assertEquals(0, $alumno['cant_cursando']);
        $this->assertEquals(2, $alumno['cant_finalizados']);
        $this->assertEquals(0, $alumno['cant_pendientes']);
        
        
        $this->assertArrayHasKey('conceptos', $tema);     
        //Debug::dump($tema['conceptos']);
        $this->assertEquals(3, count($tema['conceptos']));
        $concepto = $this->getElementFromArrayByTitulo('est_concepto_1 concepto', $tema['conceptos']);        
        $this->assertNotNull($concepto);
        
        $conceptoEsperado = $this->getConceptoByTitulo('est_concepto_1 concepto');
        $this->assertEquals($conceptoEsperado->getId(), $concepto['id']);
        $this->assertEquals($conceptoEsperado->getTitulo(), $concepto['titulo']);
        $this->assertEquals($conceptoEsperado->getOrden(), $concepto['orden']);
        $this->assertEquals(ResultadoEvaluacion::APROBADO, $concepto['estado']);
        
        $itemBankEsperado = $this->getItemBankByCode($conceptoEsperado->getId());
        
        //        
        $this->assertEquals($itemBankEsperado->getExpectedTheta(), $concepto['theta_esperado']);
        $this->assertEquals($itemBankEsperado->getItemRange(), $concepto['rango']);
        $this->assertEquals($itemBankEsperado->getDiscretIncrement(), $concepto['incremento'], '', 0.1);
        $this->assertEquals(1, $concepto['theta'], '', 0.1);
        $this->assertEquals(0.2, $concepto['theta_error'], '', 0.1);
        $this->assertNotNull($concepto['fecha_actualizacion']);        
        
        $this->assertEquals(0, $tema['cant_cursando']);
        $this->assertEquals(0, $tema['cant_pendientes']);
        $this->assertEquals(3, $tema['cant_aprobados']);
        $this->assertEquals(0, $tema['cant_aprobados_observaciones']);
        $this->assertEquals(0, $tema['cant_desaprobados']);

    }
    
    public function testGetAlumnoEstadisticaAction_conAlumnoCursando() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $curso = $this->getCursoByTitulo('Estadistica 1');
        $cursoId = $curso->getId();
        $alumnoEsperado = $this->getAlumnoByLegajo('1001');
        $alumnoId = $alumnoEsperado->getId();
        $route =  $this->getUrl('api_1_docentes_cursos_alumnosget_docente_curso_alumno_estadistica', array('docenteId' => $id, 'cursoId' => $cursoId, 'alumnoId' => $alumnoId,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $alumno = json_decode($response->getContent(), true);

        $this->assertEquals($alumnoEsperado->getId(), $alumno['id']);
        $this->assertEquals($alumnoEsperado->getUsuario()->getNombre(), $alumno['nombre']);
        $this->assertEquals($alumnoEsperado->getLegajo(), $alumno['legajo']);
        
        $this->assertArrayHasKey('temas', $alumno); 
        $this->assertEquals(2, count($alumno['temas']));
        $tema = $this->getElementFromArrayByTitulo('1000 tema', $alumno['temas']);
        $this->assertNotNull($tema);                
        $temaEsperado = $this->getTemaByTitulo('1000 tema');
        $this->assertEquals($temaEsperado->getId(), $tema['id']);
        $this->assertEquals($temaEsperado->getTitulo(), $tema['titulo']);
        $this->assertEquals($temaEsperado->getOrden(), $tema['orden']);
        $this->assertEquals(ResultadoEvaluacion::CURSANDO, $tema['estado']);
        
        $this->assertEquals(1, $alumno['cant_cursando']);
        $this->assertEquals(0, $alumno['cant_finalizados']);
        $this->assertEquals(1, $alumno['cant_pendientes']);
        
        $this->assertArrayHasKey('conceptos', $tema);     
        $this->assertEquals(3, count($tema['conceptos']));
        $concepto = $this->getElementFromArrayByTitulo('est_concepto_1 concepto', $tema['conceptos']);        
        $this->assertNotNull($concepto);
        
        $conceptoEsperado = $this->getConceptoByTitulo('est_concepto_1 concepto');
        $this->assertEquals($conceptoEsperado->getId(), $concepto['id']);
        $this->assertEquals($conceptoEsperado->getTitulo(), $concepto['titulo']);
        $this->assertEquals($conceptoEsperado->getOrden(), $concepto['orden']);
        $this->assertEquals(ResultadoEvaluacion::CURSANDO, $concepto['estado']);
        
        $itemBankEsperado = $this->getItemBankByCode($conceptoEsperado->getId());
        
        //        
        $this->assertEquals($itemBankEsperado->getExpectedTheta(), $concepto['theta_esperado']);
        $this->assertEquals($itemBankEsperado->getItemRange(), $concepto['rango']);
        $this->assertEquals($itemBankEsperado->getDiscretIncrement(), $concepto['incremento'], '', 0.1);
        $this->assertEquals(-1, $concepto['theta'], '', 1);
        $this->assertEquals(1, $concepto['theta_error'], '', 1);
        $this->assertNotNull($concepto['fecha_actualizacion']); 
        
        $this->assertEquals(1, $tema['cant_cursando']);
        $this->assertEquals(0, $tema['cant_pendientes']);
        $this->assertEquals(0, $tema['cant_aprobados']);
        $this->assertEquals(1, $tema['cant_aprobados_observaciones']);
        $this->assertEquals(1, $tema['cant_desaprobados']);
    }
    
    public function testGetAlumnoEstadisticaAction_conAlumnoSinIniciar() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $curso = $this->getCursoByTitulo('Estadistica 1');
        $cursoId = $curso->getId();
        $alumnoEsperado = $this->getAlumnoByLegajo('1002');
        $alumnoId = $alumnoEsperado->getId();
        $route =  $this->getUrl('api_1_docentes_cursos_alumnosget_docente_curso_alumno_estadistica', array('docenteId' => $id, 'cursoId' => $cursoId, 'alumnoId' => $alumnoId,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $alumno = json_decode($response->getContent(), true);

        $this->assertEquals($alumnoEsperado->getId(), $alumno['id']);
        $this->assertEquals($alumnoEsperado->getUsuario()->getNombre(), $alumno['nombre']);
        $this->assertEquals($alumnoEsperado->getLegajo(), $alumno['legajo']);
        
        $this->assertArrayHasKey('temas', $alumno); 
        $this->assertEquals(2, count($alumno['temas']));
        $tema = $this->getElementFromArrayByTitulo('1000 tema', $alumno['temas']);
        $this->assertNotNull($tema);                
        $temaEsperado = $this->getTemaByTitulo('1000 tema');
        $this->assertEquals($temaEsperado->getId(), $tema['id']);
        $this->assertEquals($temaEsperado->getTitulo(), $tema['titulo']);
        $this->assertEquals($temaEsperado->getOrden(), $tema['orden']);
        $this->assertEquals(ResultadoEvaluacion::PENDIENTE, $tema['estado']);
        $this->assertEquals(0, $alumno['cant_cursando']);
        $this->assertEquals(0, $alumno['cant_finalizados']);
        $this->assertEquals(2, $alumno['cant_pendientes']);
        
        
        $this->assertArrayHasKey('conceptos', $tema);     
        $this->assertEquals(3, count($tema['conceptos']));
        $concepto = $this->getElementFromArrayByTitulo('est_concepto_1 concepto', $tema['conceptos']);        
        $this->assertNotNull($concepto);
        
        $conceptoEsperado = $this->getConceptoByTitulo('est_concepto_1 concepto');
        $this->assertEquals($conceptoEsperado->getId(), $concepto['id']);
        $this->assertEquals($conceptoEsperado->getTitulo(), $concepto['titulo']);
        $this->assertEquals($conceptoEsperado->getOrden(), $concepto['orden']);
        $this->assertEquals(ResultadoEvaluacion::PENDIENTE, $concepto['estado']);
        
        $itemBankEsperado = $this->getItemBankByCode($conceptoEsperado->getId());
        
        //        
        $this->assertEquals($itemBankEsperado->getExpectedTheta(), $concepto['theta_esperado']);
        $this->assertEquals($itemBankEsperado->getItemRange(), $concepto['rango']);
        $this->assertEquals($itemBankEsperado->getDiscretIncrement(), $concepto['incremento'], '', 0.1);
        $this->assertEquals(-99, $concepto['theta'], '', 0.1);
        $this->assertEquals(99, $concepto['theta_error'], '', 0.1);
        $this->assertNotNull($concepto['fecha_actualizacion']);        
        
        $this->assertEquals(0, $tema['cant_cursando']);
        $this->assertEquals(3, $tema['cant_pendientes']);
        $this->assertEquals(0, $tema['cant_aprobados']);
        $this->assertEquals(0, $tema['cant_aprobados_observaciones']);
        $this->assertEquals(0, $tema['cant_desaprobados']);

    }
    
    private function getElementFromArrayByTitulo($titulo, $items) {
        foreach ($items as $item) {
            if ($item['titulo'] === $titulo) {
                return $item;
            }
        }
        return null;
    }
    
    
   /*
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
        
//        $this->assertCount($expectedTema->getSucesoras()->count(), $tema['sucesoras']);       
//        $sucesora = $tema['sucesoras'][0];
//        $expectedSucesora = $expectedTema->getSucesoras()->get(0);
//        $this->assertCamposBasicosEquals($expectedSucesora, $sucesora);                
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
        
        //$sucesora = $tema['sucesoras'][0];
        //$expectedSucesora = $this->getTema($nuevoTema['sucesoras'][0]);
        //$this->assertCamposBasicosEquals($expectedSucesora, $sucesora);
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
                
        //$this->assertEquals(1, $tema->getSucesoras()->count());
        //$sucesora = $tema->getSucesoras()->get(0);
        //$expectedSucesora = $this->getTema($temaAActualizar['sucesoras'][0]);
        //$this->assertEquals($expectedSucesora->getId(), $sucesora->getId());
    }
    
    public function testPatchAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        
        $temaDesactualizadoBBDD = $this->getTema($temaId);
        
        $temaAActualizar = array('titulo' => $temaDesactualizadoBBDD->getTitulo().' PATCH', 'habilitado' => false);
        
        $content = json_encode($temaAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temaspatch_docente_curso_tema', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, '_format' => 'json'));
  
        //test
        $cliente->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $tema = $this->getTema($temaId);
        $this->assertEquals($temaAActualizar['titulo'], $tema->getTitulo());
        $this->assertEquals($temaDesactualizadoBBDD->getDescripcion(), $tema->getDescripcion());
        $this->assertFalse($tema->isHabilitado());
      
    }
    
    public function testPatchPredecesorasAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        
        $temaDesactualizadoBBDD = $this->getTema($temaId);
        
        $temaAActualizar = array('predecesoras' => array(3));
        
        $content = json_encode($temaAActualizar);
        $route =  $this->getUrl('api_1_docentes_cursos_temaspatch_docente_curso_tema', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, '_format' => 'json'));
  
        //test
        $cliente->request('PATCH', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $tema = $this->getTema($temaId);
        
        $this->assertEquals(1, $tema->getPredecesoras()->count());        
        $predecesora = $tema->getPredecesoras()->get(0);
        $expectedPredecesora = $this->getTema($temaAActualizar['predecesoras'][0]);
        $this->assertEquals($expectedPredecesora->getId(), $predecesora->getId());
    }
    
    public function testPutAction_cambiarPredecesoras() {
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
                
        //$this->assertEquals(0, $tema->getSucesoras()->count());
        
        $temaSucesoraId = 4;
        $temaSucesora = $this->getTema($temaSucesoraId);
        $this->assertEquals(2, $temaSucesora->getPredecesoras()->count());        
        $this->assertExisteTema($tema, $temaSucesora->getPredecesoras());   
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
     
    
    
    */
    
        
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
    
    private function assertExisteTema($temaEsperado, $array) {
        foreach ($array as $tema) {
            if ($tema->getId() == $temaEsperado->getId()) {
                return;
            }
        }
        $this->assertTrue(false, 'No se encontro el tema');
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
    protected function getCursoByTitulo($titulo) {
        $curso =  $this->em
            ->getRepository('SafeCursoBundle:Curso')
            ->findOneBy(array('titulo'=>$titulo))
        ;
        $this->em->detach($curso);
        return $curso;
    }
    
    protected function getAlumnoByLegajo($legajo) {
        $alumno =  $this->em
            ->getRepository('SafeAlumnoBundle:Alumno')
            ->findOneBy(array('legajo'=>$legajo))
        ;
        $this->em->detach($alumno);
        return $alumno;
    }
    
    protected function getTemaByTitulo($titulo) {
        $tema =  $this->em
            ->getRepository('SafeTemaBundle:Tema')
            ->findOneBy(array('titulo'=>$titulo))
        ;
        $this->em->detach($tema);
        return $tema;
    }
    
    protected function getConceptoByTitulo($titulo) {
        $concepto =  $this->em
            ->getRepository('SafeTemaBundle:Concepto')
            ->findOneBy(array('titulo'=>$titulo))
        ;
        $this->em->detach($concepto);
        return $concepto;
    }
    
    protected function getItemBankByCode($code) {
        $itemBank =  $this->em
            ->getRepository('SafeCatBundle:ItemBank')
            ->findOneBy(array('code'=>$code))
        ;
        $this->em->detach($itemBank);
        return $itemBank;
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
