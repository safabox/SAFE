<?php

namespace Safe\AlumnoBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class ConceptoAsignadoControllerTest extends SafeTestController {
    
    public function testGetProximo_conceptoAction() {
        //inicio
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $tema = $this->getTemaByTitulo('4 tema');
        
        $route =  $this->getUrl('api_1_alumnos_cursos_temas_conceptosget_alumno_curso_tema_proximo_concepto', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $tema->getId() ,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $concepto = json_decode($response->getContent(), true);
        $expectedConcepto = $this->getConceptoByTitulo('3 concepto');
           
        
        $this->assertCamposBasicosEquals($expectedConcepto, $concepto);
        
    }
    
    public function testGetAction() {
        //inicio
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $tema = $this->getTemaByTitulo('4 tema');
        $expectedConcepto = $this->getConceptoByTitulo('3 concepto');
        
        $route =  $this->getUrl('api_1_alumnos_cursos_temas_conceptosget_alumno_curso_tema_concepto', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $tema->getId(), 'conceptoId' => $expectedConcepto->getId() ,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);
        $concepto = json_decode($response->getContent(), true);
        
           
        
        $this->assertCamposBasicosEquals($expectedConcepto, $concepto);
        
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
    
    protected function getAlumno($id) {
        $alumno = $this->em
            ->getRepository('SafeAlumnoBundle:Alumno')
            ->find($id)
        ;
        $this->em->detach($alumno);
        return $alumno;
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
    
    
    
}
