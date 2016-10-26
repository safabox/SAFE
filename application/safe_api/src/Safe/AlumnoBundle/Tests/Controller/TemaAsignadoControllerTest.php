<?php

namespace Safe\AlumnoBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;

use Safe\AlumnoBundle\Entity\ProximoResultado;
use Doctrine\Common\Util\Debug;
class TemaAsignadoControllerTest extends SafeTestController {
    
    public function testGetTemasAction() {
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $route =  $this->getUrl('api_1_alumnos_cursos_temasget_alumno_curso_temas', array('alumnoId' => $id, 'cursoId' => $idCurso,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $temas = json_decode($response->getContent(), true);
        
        //Debug::dump($temas, 3);
        
        $this->assertArrayHasKey('disponibles', $temas, 'temas disponibles no encontrado');
        $this->assertArrayHasKey('bloqueados', $temas, 'temas bloqueados no encontrado');
        $this->assertArrayHasKey('finalizados', $temas, 'temas finalizados no encontrado');
        
        $this->assertEquals(1, count($temas['disponibles']));
        $this->assertEquals(2, count($temas['bloqueados']));
        $this->assertEquals(2, count($temas['finalizados']));
        
        $temaDisponible = $temas['disponibles'][0];
        $this->assertCamposBasicos($temaDisponible);

        $temaBloqueado = $temas['bloqueados'][0];
        $this->assertCamposBasicos($temaBloqueado);        
    
        $temaFinalizado = $temas['finalizados'][0]['tema'];
        $this->assertCamposBasicos($temaFinalizado);
        $estado = $temas['finalizados'][0]['estado'];
        $this->assertEquals('FINALIZADO', $estado);
    }
    
    
    public function testGetProximo_temaAction() {
        //inicio
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $route =  $this->getUrl('api_1_alumnos_cursos_temasget_alumno_curso_proximo_tema', array('alumnoId' => $id, 'cursoId' => $idCurso,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $proximoResultado = json_decode($response->getContent(), true);
        $expectedTema = $this->getTemaByTitulo("4 tema");
        
        $this->assertEquals(ProximoResultado::CURSANDO, $proximoResultado['estado']);
        $this->assertCamposBasicosEquals($expectedTema, $proximoResultado['elemento']);
        
    }
    
    public function testGetProximo_temaAction_ConTodosLosTemasFinalizados_RetornaEstadoFinalizadoYCierraElCurso() {
        //inicio
        $login = $this->loginAlumno("alumno14");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $route =  $this->getUrl('api_1_alumnos_cursos_temasget_alumno_curso_proximo_tema', array('alumnoId' => $id, 'cursoId' => $idCurso,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $proximoResultado = json_decode($response->getContent(), true);

        $this->assertEquals(ProximoResultado::FINALIZADO, $proximoResultado['estado']);
        $this->assertNotNull($this->getEstadoCurso($idCurso, $id));
    }
    
    public function testGetAction() {
        //inicio
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $expectedTema = $this->getTemaByTitulo("4 tema");
        
        $route =  $this->getUrl('api_1_alumnos_cursos_temasget_alumno_curso_tema', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $expectedTema->getId(), '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $tema = json_decode($response->getContent(), true);
        
           
        $this->assertCamposBasicosEquals($expectedTema, $tema);
        
    }

    
    public function testGetProxima_actividadAction() {
        //inicio
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        //$tema = $this->getTemaByTitulo('4 tema');
        //$concepto = $this->getConceptoByTitulo('3 concepto');
        
        $route =  $this->getUrl('api_1_alumnos_cursos_temasget_alumno_curso_proxima_actividad', array('alumnoId' => $id, 'cursoId' => $idCurso,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        
        $this->assertJsonResponse($response, 200);
        $resultado = json_decode($response->getContent(), true);
      
        $expectedTema = $this->getTemaByTitulo("4 tema");        
        $this->assertEquals(ProximoResultado::CURSANDO, $resultado['tema']['estado']);
        $this->assertCamposBasicosEquals($expectedTema, $resultado['tema']['elemento']);
        
        $expectedConcepto = $this->getConceptoByTitulo('3 concepto');           
        $this->assertEquals(ProximoResultado::CURSANDO, $resultado['concepto']['estado']);
        $this->assertCamposBasicosEquals($expectedConcepto, $resultado['concepto']['elemento']);
        
        
        $expectedActividad = $this->getActividadByTitulo('4 actividad');
        $this->assertEquals(ProximoResultado::CURSANDO, $resultado['actividad']['estado']);
        $this->assertActividadCamposBasicosEquals($expectedActividad, $resultado['actividad']['elemento']);
        $this->assertArrayHasKey('ejercicio', $resultado['actividad']['elemento'], 'Ejercicio de la actividad no encontrada');
        
    }
    
    private function assertCamposBasicosEquals($expectedTema, $tema) {
        $this->assertEquals($expectedTema->getId(), $tema['id'], "Id del tema");
        $this->assertEquals($expectedTema->getTitulo(), $tema['titulo']);
        $this->assertEquals($expectedTema->getDescripcion(), $tema['descripcion']);
        $this->assertEquals($expectedTema->isHabilitado(), $tema['habilitado']);
        $this->assertEquals($expectedTema->getFechaModificacion()->format(DATE_ISO8601), $tema['fecha_modificacion']);
        $this->assertEquals($expectedTema->getFechaCreacion()->format(DATE_ISO8601), $tema['fecha_creacion']);        
        $this->assertEquals($expectedTema->getOrden(), $tema['orden']);       
    }
    
    private function assertConceptoCamposBasicosEquals($expectedConcepto, $concepto) {
        $this->assertEquals($expectedConcepto->getId(), $concepto['id']);
        $this->assertEquals($expectedConcepto->getTitulo(), $concepto['titulo']);
        $this->assertEquals($expectedConcepto->getDescripcion(), $concepto['descripcion']);
        $this->assertEquals($expectedConcepto->isHabilitado(), $concepto['habilitado']);
        $this->assertEquals($expectedConcepto->getFechaModificacion()->format(DATE_ISO8601), $concepto['fecha_modificacion']);
        $this->assertEquals($expectedConcepto->getFechaCreacion()->format(DATE_ISO8601), $concepto['fecha_creacion']);        
        $this->assertEquals($expectedConcepto->getOrden(), $concepto['orden']);       
    }
    
     private function assertActividadCamposBasicosEquals($expectedActividad, $actividad) {
        $this->assertEquals($expectedActividad->getId(), $actividad['id']);
        $this->assertEquals($expectedActividad->getTitulo(), $actividad['titulo']);
        $this->assertSame($expectedActividad->getEjercicio(), $actividad['ejercicio']);
        $this->assertEquals($expectedActividad->getDescripcion(), $actividad['descripcion']);
        $this->assertEquals($expectedActividad->isHabilitado(), $actividad['habilitado']);
        $this->assertEquals($expectedActividad->getFechaModificacion()->format(DATE_ISO8601), $actividad['fecha_modificacion']);
        $this->assertEquals($expectedActividad->getFechaCreacion()->format(DATE_ISO8601), $actividad['fecha_creacion']);        
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
    
    protected function getAlumno($id) {
        $alumno = $this->em
            ->getRepository('SafeAlumnoBundle:Alumno')
            ->find($id)
        ;
        $this->em->detach($alumno);
        return $alumno;
    }
    
    protected function getTema($id) {
        $tema =  $this->em
            ->getRepository('SafeTemaBundle:Tema')
            ->find($id)
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
    
     protected function getActividadByTitulo($titulo) {
        $actividad =  $this->em
            ->getRepository('SafeTemaBundle:Actividad')            
            ->findOneBy(array('titulo'=>$titulo))
        ;
        $this->em->detach($actividad);
        return $actividad;
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
    
    protected function getEstadoCurso($idCurso, $idAlumno) {
        $estado =  $this->em
            ->getRepository('SafeTemaBundle:AlumnoEstadoCurso')            
            ->findOneBy(array('curso'=>$idCurso, 'alumno'=>$idAlumno))
        ;
        if ($estado != null) {
            $this->em->detach($estado);
        }
        
        return $estado;
    }
    
    
    
}
