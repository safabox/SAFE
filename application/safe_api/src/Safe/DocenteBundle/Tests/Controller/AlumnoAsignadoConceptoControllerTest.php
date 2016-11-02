<?php

namespace Safe\DocenteBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Safe\CoreBundle\Tests\Controller\SafeTestController;
use Doctrine\Common\Util\Debug;
use Safe\AlumnoBundle\Entity\ResultadoEvaluacion;
use Safe\TemaBundle\Entity\Tema;
use Safe\TemaBundle\Entity\Concepto;
use Safe\CatBundle\Entity\ItemBank;
class AlumnoAsignadoConceptoControllerTest extends SafeTestController {

   
    public function testGetAlumnoEstadisticaAction() {
        //inicio
        $login = $this->loginDocente();    
        $cliente = $login['cliente'];
        $id = $login['datos']['idDocente'];
        $curso = $this->getCursoByTitulo('Estadistica 1');
        $cursoId = $curso->getId();
        $alumnoEsperado = $this->getAlumnoByLegajo('1000');
        $alumnoId = $alumnoEsperado->getId();
        $conceptoEsperado = $this->getConceptoByTitulo('est_concepto_1 concepto');
        $conceptoId = $conceptoEsperado->getId();
        $route =  $this->getUrl('api_1_docentes_cursos_alumnos_conceptosget_docente_curso_alumnos_concepto_estadistica', array('docenteId' => $id, 'cursoId' => $cursoId, 'alumnoId' => $alumnoId, 'conceptoId' => $conceptoId,'_format' => 'json'));
        
        //test
        $cliente->request('GET', $route, array('ACCEPT' => 'application/json'));
        
        //validacion
        $response = $cliente->getResponse();
        $this->assertJsonResponse($response, 200);       
        $concepto = json_decode($response->getContent(), true);
        
        
        
        
        $this->assertEquals($conceptoEsperado->getId(), $concepto['id']);
        $this->assertEquals($conceptoEsperado->getTitulo(), $concepto['titulo']);
        $this->assertEquals(ResultadoEvaluacion::APROBADO, $concepto['estado']);
        
        $itemBankEsperado = $this->getItemBankByCode($conceptoEsperado->getId());        
        $this->assertEquals($itemBankEsperado->getExpectedTheta(), $concepto['theta_esperado']);
        $this->assertEquals($itemBankEsperado->getItemRange(), $concepto['rango']);
        $this->assertEquals($itemBankEsperado->getDiscretIncrement(), $concepto['incremento'], '', 0.1);
        $this->assertEquals(1, $concepto['theta'], '', 0.1);
        $this->assertEquals(0.2, $concepto['theta_error'], '', 0.1);
        $this->assertNotNull($concepto['fecha_actualizacion']);
          
        //Debug::dump($concepto, 6);
        $this->assertEquals(7, count($concepto['thetas_anteriores']));
        $this->assertEquals(2, count($concepto['resultados']));

    }
    
    private function getElementFromArrayByTitulo($titulo, $items) {
        foreach ($items as $item) {
            if ($item['titulo'] === $titulo) {
                return $item;
            }
        }
        return null;
    }
    
    
   
    
        
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
