<?php

namespace Safe\AlumnoBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
class ActividadAsignadaControllerTest extends SafeTestController {
    
    public function testGetProximo_actividadAction() {
        //inicio
        $login = $this->loginAlumno("alumno10");                
        $cliente = $login['cliente'];                
        $id = $login['datos']['idAlumno'];
        $curso = $this->getCursoByTitulo('Asignacion');
        $idCurso = $curso->getId();
        $tema = $this->getTemaByTitulo('4 tema');
        $concepto = $this->getConceptoByTitulo('3 concepto');
        
        $route =  $this->getUrl('api_1_alumnos_cursos_temas_conceptos_actividadesget_alumno_curso_tema_proxima_actividad', array('alumnoId' => $id, 'cursoId' => $idCurso, 'temaId' => $tema->getId(), 'conceptoId' => $concepto->getId() ,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        
        $this->assertJsonResponse($response, 200);
        $actividad = json_decode($response->getContent(), true);
        $expectedActividad = $this->getActividadByTitulo('4 actividad');
           
        
        $this->assertCamposBasicosEquals($expectedActividad, $actividad);   
        $this->assertArrayHasKey('ejercicio', $actividad, 'Ejercicio de la actividad no encontrada');
        
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
    
    
    
}
