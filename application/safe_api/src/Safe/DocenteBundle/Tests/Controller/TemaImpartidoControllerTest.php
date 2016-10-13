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
        $this->assertArrayHasKey('id', $tema, 'id del tema no encontrado');
        $this->assertArrayHasKey('titulo', $tema, 'Titulo del tema no encontrado');
        $this->assertArrayHasKey('fecha_modificacion', $tema, 'Fecha de modificacion del tema no encontrada');
        $this->assertNotNull($tema['fecha_modificacion'], 'Fecha de modificacion del tema invalida');
        $this->assertArrayHasKey('fecha_creacion', $tema, 'Fecha de creacion del tema no encontrada');
        $this->assertNotNull($tema['fecha_creacion'], 'Fecha de creacion del tema invalida');

    }
    /*
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
    */
    protected function getTema($id) {
        return $this->em
            ->getRepository('SafeTemaBundle:Tema')
            ->find($id)
        ;
    }
    
    protected function getCurso($id) {
        return $this->em
            ->getRepository('SafeCursoBundle:Curso')
            ->find($id)
        ;
    }
    
}
