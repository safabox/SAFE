<?php

namespace Safe\DocenteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class CursoImpartidoControllerTest extends SafeTestController {

    
    public function testGetAllAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $route =  $this->getUrl('api_1_docentes_cursosget_docente_cursos', array('id' => $id, '_format' => 'json'));
        
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

    }
    public function testGetAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $idCurso = 1;
        $route =  $this->getUrl('api_1_docentes_cursosget_docente_curso', array('docenteId' => $id, 'id' => $idCurso,'_format' => 'json'));
        
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
