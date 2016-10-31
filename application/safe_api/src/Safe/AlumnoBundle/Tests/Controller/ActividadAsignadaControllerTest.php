<?php

namespace Safe\AlumnoBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
use Doctrine\Common\Util\Debug;
class ActividadAsignadaControllerTest extends SafeTestController {
    /*
    public function testGetProximo_actividadAction() {
        //inicio
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $tema = $this->getTemaByTitulo('4 tema');
        $concepto = $this->getConceptoByTitulo('3 concepto');
        
        $route =  $this->getUrl('api_1_alumnos_cursos_temas_conceptos_actividadesget_alumno_curso_tema_concepto_proxima_actividad', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $tema->getId(), 'conceptoId' => $concepto->getId() ,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        
        $this->assertJsonResponse($response, 200);
        $proximoResultado = json_decode($response->getContent(), true);
        $expectedActividad = $this->getActividadByTitulo('4 actividad');
        $this->assertEquals(ResultadoEvaluacion::CURSANDO, $proximoResultado['estado']);
        $this->assertCamposBasicosEquals($expectedActividad, $proximoResultado['elemento']);
        $this->assertArrayHasKey('ejercicio', $proximoResultado['elemento'], 'Ejercicio de la actividad no encontrada');        
    }
   
    public function testGetProximo_actividad_Action_ConAlumnoConHabilidadLograda_RetornaEstadoAprobado_Y_GeneraUnNuevoEstadoDeAprobacion() {
        //inicio
        $login = $this->loginAlumno("alumno11");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $tema = $this->getTemaByTitulo('4 tema');
        $concepto = $this->getConceptoByTitulo('3 concepto');
        
        $route =  $this->getUrl('api_1_alumnos_cursos_temas_conceptos_actividadesget_alumno_curso_tema_concepto_proxima_actividad', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $tema->getId(), 'conceptoId' => $concepto->getId() ,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();        
        $this->assertJsonResponse($response, 200);
        $proximoResultado = json_decode($response->getContent(), true);
        $this->assertEquals(ResultadoEvaluacion::APROBADO, $proximoResultado['estado']);
        $this->assertNull($proximoResultado['elemento']);
        
        $estadoConcepto = $this->getEstadoConcepto($concepto->getId(), $id);
        $this->assertNotNull($estadoConcepto);
        $this->assertTrue($estadoConcepto->isAprobado());
    }
    
    public function testGetProximo_actividad_Action_ConAlumnoYaAprobado_RetornaEstadoAprobado() {
        //inicio
        $login = $this->loginAlumno("alumno12");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $tema = $this->getTemaByTitulo('4 tema');
        $concepto = $this->getConceptoByTitulo('3 concepto');
        $estadoConceptoAntes = $this->getEstadoConcepto($concepto->getId(), $id);
        
        $route =  $this->getUrl('api_1_alumnos_cursos_temas_conceptos_actividadesget_alumno_curso_tema_concepto_proxima_actividad', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $tema->getId(), 'conceptoId' => $concepto->getId() ,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();        
        $this->assertJsonResponse($response, 200);
        $proximoResultado = json_decode($response->getContent(), true);
        $this->assertEquals(ResultadoEvaluacion::APROBADO, $proximoResultado['estado']);
        $this->assertNull($proximoResultado['elemento']);
        
        $estadoConceptoDespues = $this->getEstadoConcepto($concepto->getId(), $id);
        $this->assertEquals($estadoConceptoAntes, $estadoConceptoDespues);
    }
    
    public function testPostActividadResultado_ConUltimaActividad_RetornaAprobacionYCierreDeConcepto(){
        //inicio
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $tema = $this->getTemaByTitulo('4 tema');
        $concepto = $this->getConceptoByTitulo('5 concepto');
        $actividad = $this->getActividadByTitulo('15 actividad');
        $actividadId = $actividad->getId();
        $resultadoActividad = $this->crearActividadResultadoArray($actividadId, array('respuesta' => 'true'));
        $content = json_encode($resultadoActividad);
        $route =  $this->getUrl('api_1_alumnos_cursos_temas_conceptos_actividadespost_alumno_curso_tema_concepto_resultado', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $tema->getId(), 'conceptoId' => $concepto->getId(),'_format' => 'json'));
        
        $cliente->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $estado = json_decode($response->getContent(), true);
                
        $this->assertEquals(ResultadoEvaluacion::APROBADO, $estado['resultado']);
        $this->assertEquals(ResultadoEvaluacion::APROBADO_OBSERVACION, $estado['proxima_actividad']['estado']);
        
    }
    */
    public function testPostActividadResultado_ConUnicaActividad_RetornaAprobacionYCierreDeConcepto(){
        //inicio
        $login = $this->loginAlumno("alumno15");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('AsignacionUnaActividad');
        $idCurso = $curso->getId();
        $tema = $this->getTemaByTitulo('100 tema');
        $concepto = $this->getConceptoByTitulo('100 concepto');
        $actividad = $this->getActividadByTitulo('100 actividad');
        $actividadId = $actividad->getId();
        $resultadoActividad = $this->crearActividadResultadoArray($actividadId, array(1,3));
        $content = json_encode($resultadoActividad);
        $route =  $this->getUrl('api_1_alumnos_cursos_temas_conceptos_actividadespost_alumno_curso_tema_concepto_resultado', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $tema->getId(), 'conceptoId' => $concepto->getId(),'_format' => 'json'));
        
        $cliente->request('POST', $route, array(), array(), array('CONTENT_TYPE' => 'application/json'), $content);
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $estado = json_decode($response->getContent(), true);
                
        $this->assertEquals(ResultadoEvaluacion::APROBADO, $estado['resultado']);
        $this->assertEquals(ResultadoEvaluacion::DESAPROBADO, $estado['proxima_actividad']['estado']);
        
    }

    private function assertCamposBasicosEquals($expectedActividad, $actividad) {
        $this->assertEquals($expectedActividad->getId(), $actividad['id']);
        $this->assertEquals($expectedActividad->getTitulo(), $actividad['titulo']);
        $this->assertSame($expectedActividad->getEjercicio(), $actividad['ejercicio']);
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
        $this->assertNotNull($actividad['fecha_modificacion'], 'Fecha de modificacion de la actividad invalida');
        $this->assertArrayHasKey('fecha_creacion', $actividad, 'Fecha de creacion de la actividad no encontrada');
        $this->assertNotNull($actividad['fecha_creacion'], 'Fecha de creacion de la actividad invalida');        
    }
    

    protected function getConceptoByTitulo($titulo) {
        $concepto =  $this->em
            ->getRepository('SafeTemaBundle:Concepto')            
            ->findOneBy(array('titulo'=>$titulo))
        ;
        $this->em->detach($concepto);
        return $concepto;
    }
    
    protected function getTemaByTitulo($titulo) {
        $tema =  $this->em
            ->getRepository('SafeTemaBundle:Tema')            
            ->findOneBy(array('titulo'=>$titulo))
        ;
        $this->em->detach($tema);
        return $tema;
    }
    
    protected function getCursoByTitulo($titulo) {
        $curso =  $this->em
            ->getRepository('SafeCursoBundle:Curso')
            ->findOneBy(array('titulo'=>$titulo))
        ;
        $this->em->detach($curso);
        return $curso;
    }
    
    protected function getActividadByTitulo($titulo) {
        $actividad =  $this->em
            ->getRepository('SafeTemaBundle:Actividad')            
            ->findOneBy(array('titulo'=>$titulo))
        ;
        $this->em->detach($actividad);
        return $actividad;
    }
    
    protected function getEstadoConcepto($idConcepto, $idAlumno) {
        $estado =  $this->em
            ->getRepository('SafeTemaBundle:AlumnoEstadoConcepto')            
            ->findOneBy(array('concepto'=>$idConcepto, 'alumno'=>$idAlumno))
        ;
        if ($estado != null) {
            $this->em->detach($estado);
        }
        
        return $estado;
    }
    
    
    protected function crearActividadResultadoArray($actividadId, $resultado = array()) {
        $dato = array(
            'actividadId' => $actividadId,
            'resultado' => $resultado
        );
        return $dato;
    }
    
    
}
