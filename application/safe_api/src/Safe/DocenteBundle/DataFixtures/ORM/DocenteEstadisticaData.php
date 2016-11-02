<?php
namespace Safe\DocenteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Safe\DocenteBundle\DataFixtures\ORM\DocenteData;
use Safe\DocenteBundle\Entity\Docente;
use Safe\AlumnoBundle\Entity\Alumno;
use Safe\CursoBundle\Entity\Curso;
use Safe\TemaBundle\Entity\Tema;
use Safe\TemaBundle\Entity\Concepto;
use Safe\CatBundle\Entity\Examinee;
use Safe\CatBundle\Entity\PastAbility;
use Safe\CatBundle\Entity\Ability;
use Safe\CatBundle\Entity\ItemBank;
use Safe\TemaBundle\Entity\AlumnoEstadoTema;
use Safe\TemaBundle\Entity\AlumnoEstadoCurso;
use Safe\TemaBundle\Entity\AlumnoEstadoConcepto;
use Doctrine\Common\Util\Debug;
class DocenteEStadisticaData extends DocenteData
{
    
    public function crearDocente($username='docente', $legajo='0', $curriculum='Experto') {
        $docente = new Docente();
        $docente->setId($legajo);
        $docente->setCurriculum($curriculum);
        $docente->setLegajo($legajo);
        $docente->setUsuario($this->crearUsuario($username, '123456', array('ROLE_DOCENTE')));
        $docente->setInstituto($this->getReference('instituto'));
        return $docente;
                
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {        
        /***El curso tiene 3 alumno de los cuales solo termino el alumno 1***/
        $docente = $this->getReference('docente1'); 
        
        $alumno1 = $this->crearAlumno('alumnoEst1', '1000');
        $manager->persist($alumno1->getUsuario());
        $manager->persist($alumno1);                
        $manager->flush();
        $examinee1 = new Examinee();
        $examinee1->setCode($alumno1->getId());
        $manager->persist($examinee1);
        $manager->flush();
        
        $alumno2 = $this->crearAlumno('alumnoEst2', '1001');
        $manager->persist($alumno2->getUsuario());
        $manager->persist($alumno2);                
        $manager->flush();
        $examinee2 = new Examinee();
        $examinee2->setCode($alumno2->getId());
        $manager->persist($examinee2);
        $manager->flush();
        
        $alumno3 = $this->crearAlumno('alumnoEst3', '1002');
        $manager->persist($alumno3->getUsuario());
        $manager->persist($alumno3);                
        $manager->flush();
        $examinee3 = new Examinee();
        $examinee3->setCode($alumno3->getId());
        $manager->persist($examinee3);
        $manager->flush();

        $curso = new Curso();
        $curso->setInstituto($this->getReference('instituto'));
        $curso->setTitulo('Estadistica 1');
        $curso->setDescripcion('Curso de estadisticas 1');
        $curso->setDocentes(array($docente));
        $curso->setAlumnos(array($alumno1, $alumno2, $alumno3));
        
        $manager->persist($curso);                
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoCurso($alumno1, $curso, true));
        $manager->flush();
        
        $tema1 = $this->crearTema("1000", $curso);
        $manager->persist($tema1);
        $manager->flush();
        
    
        $manager->persist(new AlumnoEstadoTema($alumno1, $tema1, true));
        $manager->persist(new AlumnoEstadoTema($alumno2, $tema1, true, 'CURSANDO'));
        $manager->flush();
        
        
        $tema2 = $this->crearTema("200", $curso, false);        
        $manager->persist($tema2);
        $manager->flush();
       
        $manager->persist(new AlumnoEstadoTema($alumno1, $tema2, true));
        $manager->flush();
        
        /*
         * El tema 1 tiene 3 conceptos
         * De los cuales el alumno 1y 2 tienen todos los conceptos
         * **/
        $concepto1 = $this->crearConcepto("est_concepto_1", $tema1, true);
        $manager->persist($concepto1);
        $manager->flush();
        $itemBank1 = new ItemBank();
        $itemBank1->setExpectedTheta(1);
        $itemBank1->setCode($concepto1->getId());
        $manager->persist($itemBank1);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno1, $concepto1, true, 'APROBADO'));
        $manager->persist(new AlumnoEstadoConcepto($alumno2, $concepto1, true, 'CURSANDO'));
        $manager->flush();
        
        $ability = new Ability($examinee1, $itemBank1, 1.5, 0.2);
        $manager->persist($ability);
        $manager->persist(new Ability($examinee2, $itemBank1, -1, 1));
        //$manager->persist(new Ability($examinee3, $itemBank1, 0));
        $manager->flush();
        
        $manager->persist(new PastAbility($ability));
        $manager->flush();
        
        
        $ability->setTheta(-2);
        $manager->persist(new PastAbility($ability));
        $manager->flush();
        
        $ability->setTheta(-1.5);
        $manager->persist(new PastAbility($ability));
        $manager->flush();
        
        $ability->setTheta(-1);
        $manager->persist(new PastAbility($ability));
        $manager->flush();
        
        $ability->setTheta(0.3);
        $manager->persist(new PastAbility($ability));
        $manager->flush();
        
        $ability->setTheta(0.7);
        $manager->persist(new PastAbility($ability));
        $manager->flush();
        
        $ability->setTheta(1);
        $manager->persist(new PastAbility($ability));
        $manager->flush();
        
        
        $concepto2 = $this->crearConcepto("est_concepto_2", $tema1, true);
        $manager->persist($concepto2);
        $manager->flush();
        $itemBank2 = new ItemBank();
        $itemBank2->setExpectedTheta(1);
        $itemBank2->setCode($concepto2->getId());
        $manager->persist($itemBank2);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno1, $concepto2, true, 'APROBADO'));
        $manager->persist(new AlumnoEstadoConcepto($alumno2, $concepto2, true, 'APROBADO_OBSERVACION'));
        $manager->flush();
        
        $manager->persist(new Ability($examinee1, $itemBank2, 0));
        $manager->persist(new Ability($examinee2, $itemBank2, 0));
        $manager->flush();
        
        $concepto3 = $this->crearConcepto("est_concepto_3", $tema1, true);
        $manager->persist($concepto3);
        $manager->flush();
        $itemBank3 = new ItemBank();
        $itemBank3->setExpectedTheta(1);
        $itemBank3->setCode($concepto3->getId());
        $manager->persist($itemBank3);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno1, $concepto3, true, 'APROBADO'));
        $manager->persist(new AlumnoEstadoConcepto($alumno2, $concepto3, false, 'DESAPROBADO'));
        $manager->flush();
        
        $manager->persist(new Ability($examinee1, $itemBank3, 0));
        $manager->persist(new Ability($examinee2, $itemBank3, 0));
        $manager->flush();
    }

    public function getOrder() {
        return 12;
    }
    
    private function crearTema($numero, $curso, $habilitado=true, $orden=1) {
        $tema = new Tema();
        $tema->setTitulo($numero." tema");
        $tema->setCopete($numero." copete del tema");
        $tema->setDescripcion("descripcion del Tema". $numero);
        $tema->setCurso($curso);
        $tema->setOrden($orden);
        $tema->setHabilitado($habilitado);
        return $tema;
    }

    public function crearAlumno($username='alumno', $legajo='0') {
        $alumno = new Alumno();
        $alumno->setId($legajo);
        $alumno->setLegajo($legajo);
        $alumno->setUsuario($this->crearUsuario($username, '123456', array('ROLE_ALUMNO')));
        $alumno->setInstituto($this->getReference('instituto'));        
        return $alumno;
                
    }
    
     public function crearConcepto($numero, $tema, $habilitado=true, $orden=1) {
        $concepto = new Concepto();
        $concepto->setTitulo($numero." concepto");
        $concepto->setDescripcion("descripcion del concepto ".$numero);
        $concepto->setTema($tema);
        $concepto->setOrden($orden);
        $concepto->setHabilitado($habilitado);
        
        return $concepto;
    }
}
