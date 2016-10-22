<?php

namespace Safe\AlumnoBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;

use Safe\AlumnoBundle\Entity\ProximoResultado;
use Doctrine\Common\Util\Debug;
class TemaAsignadoControllerTest extends SafeTestController {
    
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
           
        $this->assertCamposBasicosEquals($expectedTema, $proximoResultado['elemento']);
        $this->assertEquals(ProximoResultado::CURSANDO, $proximoResultado['estado']);
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
    
    
    private function assertCamposBasicosEquals($expectedTema, $tema) {
        $this->assertEquals($expectedTema->getId(), $tema['id'], "Id del tema");
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
