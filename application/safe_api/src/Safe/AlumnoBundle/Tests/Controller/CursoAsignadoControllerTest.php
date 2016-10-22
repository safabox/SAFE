<?php

namespace Safe\AlumnoBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class CursoAsignadoControllerTest extends SafeTestController {

        
    public function testGetAllAction() {
        //inicio
        $login = $this->loginAlumno();                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $route =  $this->getUrl('api_1_alumnos_cursosget_alumno_cursos', array('id' => $id, '_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $cursos = json_decode($response->getContent(), true);
        
        $this->assertCount(2, $cursos);
        
        $curso = $cursos[0];
        $this->assertArrayHasKey('id', $curso, 'id del curso no encontrado');
        $this->assertArrayHasKey('titulo', $curso, 'Titulo del curso no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $curso, 'Fecha de modificacion del curso no encontrada');
        $this->assertNotNull($curso['fecha_modificacion'], 'Fecha de modificacion del curso invalida');
        $this->assertArrayHasKey('fecha_creacion', $curso, 'Fecha de creacion del curso no encontrada');
        $this->assertNotNull($curso['fecha_creacion'], 'Fecha de creacion del curso invalida');
        $this->assertArrayNotHasKey('temas', $curso, 'temas no permitido en el listaod');
        $this->assertArrayNotHasKey('docentes', $curso, 'docentes no permitido en el listado');
        $this->assertArrayNotHasKey('alumnos', $curso, 'alumnos no permitido en el listado');
        $this->assertArrayNotHasKey('descripcion', $curso, 'alumnos no permitido en el listado');
    }
    
    public function testGetAction() {
        //inicio
        $login = $this->loginAlumno();                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $idCurso = 1;
        $route =  $this->getUrl('api_1_alumnos_cursosget_alumno_curso', array('docenteId' => $id, 'id' => $idCurso,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $curso = json_decode($response->getContent(), true);
        $expectedCurso = $this->getCurso($idCurso);
                
        $this->assertEquals($expectedCurso->getId(), $curso['id']);
        $this->assertEquals($expectedCurso->getTitulo(), $curso['titulo']);
        $this->assertEquals($expectedCurso->getDescripcion(), $curso['descripcion']);
        $this->assertEquals($expectedCurso->getFechaModificacion()->format(DATE_ISO8601), $curso['fecha_modificacion']);
        $this->assertEquals($expectedCurso->getFechaCreacion()->format(DATE_ISO8601), $curso['fecha_creacion']);        
        
                
        $this->assertEquals($expectedCurso->getDocentes()->count(), count($curso['docentes']));  
        $this->assertEquals($expectedCurso->getDocentes()->get(0)->getId(), $curso['docentes'][0]['id']);  
        
        $this->assertEquals($expectedCurso->getAlumnos()->count(), count($curso['alumnos']));        
        $this->assertEquals($expectedCurso->getAlumnos()->get(0)->getId(), $curso['alumnos'][0]['id']);
    }
    
    protected function getAlumno($id) {
        $alumno = $this->em
            ->getRepository('SafeAlumnoBundle:Alumno')
            ->find($id)
        ;
        $this->em->detach($alumno);
        return $alumno;
    }
    
    protected function getCurso($id) {
        $curso =  $this->em
            ->getRepository('SafeCursoBundle:Curso')
            ->find($id)
        ;
        $this->em->detach($curso);
        return $curso;
    }
    
    
    
}
