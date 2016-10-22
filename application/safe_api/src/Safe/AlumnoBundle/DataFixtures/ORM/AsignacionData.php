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
use Safe\TemaBundle\Entity\AlumnoEstadoTema;
use Safe\TemaBundle\Entity\AlumnoEstadoConcepto;


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
        $manager->flush();
        
        
        $tema2 = $this->crearTema("2", $curso, false);
        $tema2->getPredecesoras()->add($tema1);
        $manager->persist($tema2);
        $manager->flush();
        
        
        $tema3 = $this->crearTema("3", $curso);
        $tema3->getPredecesoras()->add($tema1);
        $manager->persist($tema3);
        $manager->flush();

        $manager->persist(new AlumnoEstadoTema($alumno, $tema3, true));
        $manager->flush();

        
        $tema4 = $this->crearTema("4", $curso, true, 100);
        $tema4->getPredecesoras()->add($tema2);
        $manager->persist($tema4);
        $manager->flush();
   
        $tema5 = $this->crearTema("5", $curso);
        $tema5->getPredecesoras()->add($tema3);
        $tema5->getPredecesoras()->add($tema4);
        $manager->persist($tema5);
        $manager->flush();

        $tema6 = $this->crearTema("6", $curso);
        $tema6->getPredecesoras()->add($tema4);
        $tema6->getPredecesoras()->add($tema5);
        $manager->persist($tema4);
        $manager->flush();
        
        $concepto1 = $this->crearConcepto("1", $tema4, false);
        $manager->persist($concepto1);
        $manager->flush();
        

        $concepto2 = $this->crearConcepto("2", $tema4);
        $concepto2->getPredecesoras()->add($concepto1);
        $manager->persist($concepto2);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno, $concepto2, false));
        $manager->flush();


        $concepto3 = $this->crearConcepto("3", $tema4, true, 10);
        $concepto3->getPredecesoras()->add($concepto2);
        $manager->persist($concepto3);
        $manager->flush();


        $concepto4 = $this->crearConcepto("4", $tema4);
        $concepto4->getPredecesoras()->add($concepto2);
        $manager->persist($concepto4);
        $manager->flush();
        
        $manager->persist(new AlumnoEstadoConcepto($alumno, $concepto4, true));
        $manager->flush();


        $concepto5 = $this->crearConcepto("5", $tema4, true, 8);
        $concepto5->getPredecesoras()->add($concepto2);
        $concepto5->getPredecesoras()->add($concepto3);
        $manager->persist($concepto5);
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
    
    /*
     Tema1(OK)->Tema2(Deshabilitado)     Tema4(Orden 100) ->Tema5() ->Tema6
     Tema1(OK)->Tema3(OK)                      ->Tema5 ->Tema6

     Tema4:
      Concepto1(Deshabilitado)-> concepto2(OK) -> Concepto 3 (orden 10)
      Concepto1(Deshabilitado)-> concepto2(OK) -> Concepto 4 (OK)
      Concepto1(Deshabilitado)-> concepto2(OK) -> Concepto 5 (orden 8)
      Concepto1(Deshabilitado)-> concepto2(OK) -> Concepto 3 -> Concepto 5 

     */
}
