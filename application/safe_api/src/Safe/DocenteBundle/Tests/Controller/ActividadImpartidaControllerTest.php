<?php

namespace Safe\DocenteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
use Safe\TemaBundle\Entity\TipoActividad;
class ActividadImpartidaControllerTest extends SafeTestController {

    public function testGetAllAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 1;
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptos_actividadesget_docente_curso_tema_concepto_actividades', array('docenteId' => $id, 'cursoId' => $cursoId, 'temaId' => $temaId, 'conceptoId' => $conceptoId, '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $actividads = json_decode($response->getContent(), true);
        $this->assertCount(5, $actividads);
        
        $actividad = $actividads[0];
        $this->assertCamposBasicos($actividad);
        //$this->assertArrayNotHasKey('ejercicio', $actividad, 'Ejercicio de la actividad no tiene que ser mostrada');
        //$this->assertArrayNotHasKey('dificultad', $actividad);
       //$this->assertArrayNotHasKey('discriminador', $actividad);
        //$this->assertArrayNotHasKey('azar', $actividad);
        //$this->assertArrayNotHasKey('d', $actividad);
 
    }

    public function testGetAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 1;
        $actividadId = 2;
        
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptos_actividadesget_docente_curso_tema_concepto_actividad', 
                  array('docenteId' => $id, 
                        'cursoId' => $cursoId, 
                        'temaId' => $temaId, 
                        'conceptoId' => $conceptoId, 
                        'actividadId' => $actividadId, '_format' => 'json'));
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $actividad = json_decode($response->getContent(), true);
        $expectedActividad = $this->getActividad($actividadId);
           
        
        $this->assertCamposBasicosEquals($expectedActividad, $actividad);   
        $this->assertArrayHasKey('ejercicio', $actividad, 'Ejercicio de la actividad no encontrada');
        $this->assertArrayHasKey('resultado', $actividad, 'Resultado de la actividad no encontrada');
        
        $this->assertArrayHasKey('dificultad', $actividad);
        $this->assertArrayHasKey('discriminador', $actividad);
        $this->assertArrayHasKey('azar', $actividad);
        $this->assertArrayHasKey('d', $actividad);
    }

    public function testPostAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 1;
        
        $nuevaActividad = $this->crearActividadArray('Actividad POST', 'Actividad descripcion POST', 
                array(
                    'atributo_1' => 'atributo 1',
                    'atributo_2' =>array(
                        'atributo_2.1' => 'atributo_2.1'
                    )
                ), 1.1, 2, -1, 1.7);
        $content = json_encode($nuevaActividad);
        
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptos_actividadespost_docente_curso_tema_concepto_actividad', 
                  array('docenteId' => $id, 
                        'cursoId' => $cursoId, 
                        'temaId' => $temaId, 
                        'conceptoId' => $conceptoId, '_format' => 'json'));
        //test
        $cliente->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $actividad = json_decode($response->getContent(), true);
        $this->assertCamposBasicos($actividad);
        
        $this->assertSame($nuevaActividad['ejercicio'], $actividad['ejercicio']);
        $this->assertSame($nuevaActividad['resultado'], $actividad['resultado']);
         
        $this->assertEquals(1.1, $actividad['dificultad'], '', 0.1);
        $this->assertEquals(2, $actividad['discriminador'], '', 0);
        $this->assertEquals(-1, $actividad['azar'], '', 0);
        $this->assertEquals(1.7, $actividad['d'], '', 0.1);
    }
    public function testPutAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $cursoId = 1;
        $temaId = 1;
        $conceptoId = 1;
        $actividadId = 1;
        
        $actividadDesactualizadoBBDD = $this->getActividad($actividadId);
        $nuevaActividad = $this->crearActividadArray($actividadDesactualizadoBBDD->getTitulo().' PUT', $actividadDesactualizadoBBDD->getDescripcion().' PUT', 
                array(
                    'atributo_1' => 'atributo 2',
                    'atributo_2' =>array(
                        'atributo_2.1' => 'atributo_2.2'
                    )
                ));
                
        $content = json_encode($nuevaActividad);
        
        $route =  $this->getUrl('api_1_docentes_cursos_temas_conceptos_actividadesput_docente_curso_tema_concepto_actividad', 
                  array('docenteId' => $id, 
                        'cursoId' => $cursoId, 
                        'temaId' => $temaId, 
                        'conceptoId' => $conceptoId, 
                        'actividadId' => $actividadId, '_format' => 'json'));
        //test
        $cliente->request('PUT', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
       
        $response = $cliente->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), 'Se esperaba status code 204 en vez de '.$response->getStatusCode());
        $actividadActualizada = $this->getActividad($actividadId);
                   
        $this->assertEquals($nuevaActividad['titulo'], $actividadActualizada->getTitulo());
        $this->assertEquals($nuevaActividad['descripcion'], $actividadActualizada->getDescripcion());
        $this->assertSame($nuevaActividad['ejercicio'], $actividadActualizada->getEjercicio());
        $this->assertSame($nuevaActividad['resultado'], $actividadActualizada->getResultado());
        $this->assertEquals($nuevaActividad['habilitado'], $actividadActualizada->isHabilitado());
    }      
    private function assertCamposBasicosEquals($expectedActividad, $actividad) {
        $this->assertEquals($expectedActividad->getId(), $actividad['id']);
        $this->assertEquals($expectedActividad->getTitulo(), $actividad['titulo']);
        $this->assertSame($expectedActividad->getEjercicio(), $actividad['ejercicio']);
        $this->assertSame($expectedActividad->getResultado(), $actividad['resultado']);
        $this->assertSame($expectedActividad->getTipo(), $actividad['tipo']);
        $this->assertEquals($expectedActividad->getDescripcion(), $actividad['descripcion']);
        $this->assertEquals($expectedActividad->isHabilitado(), $actividad['habilitado']);
        $this->assertEquals($expectedActividad->getFechaModificacion()->format(DATE_ISO8601), $actividad['fecha_modificacion']);
        $this->assertEquals($expectedActividad->getFechaCreacion()->format(DATE_ISO8601), $actividad['fecha_creacion']);        
    }
    
    private function assertCamposBasicos($actividad){
        $this->assertArrayHasKey('id', $actividad, 'id del actividad no encontrado');
        $this->assertArrayHasKey('titulo', $actividad, 'Titulo de la actividad no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $actividad, 'Fecha de modificacion de la actividad no encontrada');
        $this->assertArrayHasKey('habilitado', $actividad, 'Estado del actividad no encontrada');
        $this->assertArrayHasKey('tipo', $actividad, 'Tipo actividad no encontrada');
        $this->assertNotNull($actividad['fecha_modificacion'], 'Fecha de modificacion de la actividad invalida');
        $this->assertArrayHasKey('fecha_creacion', $actividad, 'Fecha de creacion de la actividad no encontrada');
        $this->assertNotNull($actividad['fecha_creacion'], 'Fecha de creacion de la actividad invalida');        
    }
    
    protected function getActividad($id) {
        
        $actividad = $this->em
            ->getRepository('SafeTemaBundle:Actividad')
            ->find($id)
        ;
        $this->em->detach($actividad);
        return $actividad;
    }
    
    
    protected function crearActividadArray($titulo, $descripcion, $ejercicio = array(), $dificultad=0, $discriminador=0, $azar=0, $d=0) {        
        $dato = array(
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'habilitado' => true,
            'ejercicio' => $ejercicio,
            'resultado' => array('resultado_ejercicio' => $ejercicio),
            'tipo' => TipoActividad::MULTIPLE_CHOICE,
            'dificultad' => $dificultad,
            'discriminador' => $discriminador,
            'azar' => $azar,
            'd' => $d,
        );
        return $dato;
    }
    
}
