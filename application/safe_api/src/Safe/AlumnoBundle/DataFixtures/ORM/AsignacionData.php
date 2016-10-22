<?php
namespace Safe\AlumnoBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Safe\PerfilBundle\DataFixtures\ORM\PerfilDataAbstract;
use Safe\AlumnoBundle\DataFixtures\ORM\AlumnoData;
use Doctrine\Common\Util\Debug;

use Safe\AlumnoBundle\Entity\Alumno;
use Safe\CursoBundle\Entity\Curso;
use Safe\TemaBundle\Entity\Tema;
use Safe\TemaBundle\Entity\Concepto;
use Safe\TemaBundle\Entity\Actividad;
use Safe\TemaBundle\Entity\AlumnoEstadoTema;
use Safe\TemaBundle\Entity\AlumnoEstadoConcepto;
use Safe\CatBundle\Entity\ItemBank;
use Safe\CatBundle\Entity\Item;
use Safe\CatBundle\Entity\ItemType;
use Safe\CatBundle\Entity\ThetaEstimationMethodType;

use Safe\CatBundle\Entity\Ability;
use Safe\CatBundle\Entity\PastAbility;
use Safe\CatBundle\Entity\Examinee;
use Safe\CatBundle\Entity\ItemResult;

class AsignacionData extends AlumnoData
{    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {        

        $alumno = $this->crearAlumno('alumno10', '10');
        $manager->persist($alumno->getUsuario());
        $manager->persist($alumno);                
        $manager->flush();
        $this->addReference('alumno10', $alumno);
        
        $alumno11 = $this->crearAlumno('alumno11', '11');
        $manager->persist($alumno11->getUsuario());
        $manager->persist($alumno11);                
        $manager->flush();
        $this->addReference('alumno11', $alumno11);
        
        $alumno12 = $this->crearAlumno('alumno12', '12');
        $manager->persist($alumno12->getUsuario());
        $manager->persist($alumno12);                
        $manager->flush();
        $this->addReference('alumno12', $alumno12);
        
        $alumno13 = $this->crearAlumno('alumno13', '13');
        $manager->persist($alumno13->getUsuario());
        $manager->persist($alumno13);                
        $manager->flush();
        $this->addReference('alumno13', $alumno13);
        
        $alumno14 = $this->crearAlumno('alumno14', '14');
        $manager->persist($alumno14->getUsuario());
        $manager->persist($alumno14);                
        $manager->flush();
        $this->addReference('alumno14', $alumno14);
        
        $curso = new Curso();
        $curso->setInstituto($this->getReference('instituto'));
        $curso->setTitulo('Asignacion');
        $curso->setDescripcion('Curso para simular las asignaciones');
        $curso->setDocentes(array($this->getReference('docente1')));
        $curso->setAlumnos(array($alumno, $alumno11));         
        $manager->persist($curso);                
        $manager->flush();
        
        $tema1 = $this->crearTema("1", $curso);
        $manager->persist($tema1);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoTema($alumno, $tema1, true));
        $manager->persist(new AlumnoEstadoTema($alumno14, $tema1, true));
        $manager->flush();
        
        
        $tema2 = $this->crearTema("2", $curso, false);
        $tema2->getPredecesoras()->add($tema1);
        $manager->persist($tema2);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoTema($alumno14, $tema2, true));
        $manager->flush();
        
        $tema3 = $this->crearTema("3", $curso);
        $tema3->getPredecesoras()->add($tema1);
        $manager->persist($tema3);
        $manager->flush();

        $manager->persist(new AlumnoEstadoTema($alumno, $tema3, true));
        $manager->persist(new AlumnoEstadoTema($alumno14, $tema3, true));
        $manager->flush();

        
        $tema4 = $this->crearTema("4", $curso, true, 100);
        $tema4->getPredecesoras()->add($tema2);
        $manager->persist($tema4);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoTema($alumno14, $tema4, true, 'FINALIZADO'));
        $manager->flush();
   
        $tema5 = $this->crearTema("5", $curso);
        $tema5->getPredecesoras()->add($tema3);
        $tema5->getPredecesoras()->add($tema4);
        $manager->persist($tema5);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoTema($alumno14, $tema5, true));
        $manager->flush();

        $tema6 = $this->crearTema("6", $curso);
        $tema6->getPredecesoras()->add($tema4);
        $tema6->getPredecesoras()->add($tema5);
        $manager->persist($tema6);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoTema($alumno14, $tema6, true));
        $manager->flush();
        
        $concepto1 = $this->crearConcepto("1", $tema4, false);
        $manager->persist($concepto1);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno13, $concepto1, true));
        $manager->flush();
        
        $concepto2 = $this->crearConcepto("2", $tema4);
        $concepto2->getPredecesoras()->add($concepto1);
        $manager->persist($concepto2);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno, $concepto2, false));
        $manager->persist(new AlumnoEstadoConcepto($alumno13, $concepto2, true));
        $manager->flush();


        $concepto3 = $this->crearConcepto("3", $tema4, true, 10);
        $concepto3->getPredecesoras()->add($concepto2);
        $manager->persist($concepto3);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno12, $concepto3, false));
        $manager->persist(new AlumnoEstadoConcepto($alumno13, $concepto3, true));
        $manager->flush();
        
        $itemBank = new ItemBank();
        $itemBank->setExpectedTheta(1);
        $itemBank->setCode($concepto3->getId());
        $manager->persist($itemBank);
        $manager->flush();
        
        $examinee = new Examinee();
        $examinee->setCode($alumno->getId());
        $manager->persist($examinee);
 
        $ability = new Ability($examinee, $itemBank, 0);
        $manager->persist($ability);
        
        
        $examinee2 = new Examinee();
        $examinee2->setCode($alumno11->getId());
        $manager->persist($examinee2);
 
        $ability = new Ability($examinee2, $itemBank, 1, 0.1);
        $manager->persist($ability);
        $manager->flush();
        
        $actividad1 = $this->crearActividad("1", $concepto3);
        $manager->persist($actividad1);
        $manager->flush();
        
        $item = $this->crearItem($actividad1, $itemBank, 1);
        $itemResult = ItemResult::fromItem($examinee, $item, 1);
        $manager->persist($item);
        $manager->persist($itemResult);
        $manager->flush();
        
        $actividad2 = $this->crearActividad("2", $concepto3, false);
        $manager->persist($actividad2);
        $manager->flush();
        
        $actividad3 = $this->crearActividad("3", $concepto3);
        $manager->persist($actividad3);
        $manager->flush();
        
        $item = $this->crearItem($actividad3, $itemBank, -1);
        $manager->persist($item);
        $manager->flush();
        
        $actividad4 = $this->crearActividad("4", $concepto3);
        $manager->persist($actividad4);
        $manager->flush();
        
        $item = $this->crearItem($actividad4, $itemBank, 1);
        $manager->persist($item);
        $manager->flush();
        
        
        $concepto4 = $this->crearConcepto("4", $tema4);
        $concepto4->getPredecesoras()->add($concepto2);
        $manager->persist($concepto4);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno, $concepto4, true));
        $manager->persist(new AlumnoEstadoConcepto($alumno13, $concepto4, true));
        $manager->flush();


        $concepto5 = $this->crearConcepto("5", $tema4, true, 8);
        $concepto5->getPredecesoras()->add($concepto2);
        $concepto5->getPredecesoras()->add($concepto3);
        $manager->persist($concepto5);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno13, $concepto5, true));
        $manager->flush();
        
        
    }

    public function getOrder() {
        return 11;
    }
    
    private function crearTema($numero, $curso, $habilitado=true, $orden=1) {
        $tema = new Tema();
        $tema->setTitulo($numero." tema");
        $tema->setDescripcion("descripcion del Tema". $numero);
        $tema->setCurso($curso);
        $tema->setOrden($orden);
        $tema->setHabilitado($habilitado);
        return $tema;
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
    
    public function crearActividad($numero, $concepto, $habilitado=true, $ejercicio=array(), $descripcion='descripcion de la actividad') {
        $actividad = new Actividad($numero." actividad");
        $actividad->setDescripcion($descripcion);
        $actividad->setConcepto($concepto);
        $actividad->setHabilitado($habilitado);        
        $actividad->setEjercicio($ejercicio);
        return $actividad;
    }
    
    public function crearItem($actividad, $itemBank, $dificultad) {
        $item = new Item($dificultad);
        $item->setItemBank($itemBank);
        $item->setCode($actividad->getId());
        return $item;
    }
    
    /*
     Tema1(OK)->Tema2(Deshabilitado)     Tema4(Orden 100) ->Tema5() ->Tema6
     Tema1(OK)->Tema3(OK)                      ->Tema5 ->Tema6

     Tema4:
        Concepto1(Deshabilitado)-> concepto2(OK) -> Concepto 3 (orden 10)
        Concepto1(Deshabilitado)-> concepto2(OK) -> Concepto 4 (OK)
        Concepto1(Deshabilitado)-> concepto2(OK) -> Concepto 5 (orden 8)
        Concepto1(Deshabilitado)-> concepto2(OK) -> Concepto 3 -> Concepto 5 

     Concepto 3
        Actividad 1. resuelta bien theta 1
        Actividad 2  deshabilitada
        Actividad 3  theta -1
        Actividad 4  theta 1
     
    Para el alumno 13 Tiene todo los conceptos cierra el tema.
    Para el alumno 14 Tiene todo los conceptos el curso.
    */
    
}
