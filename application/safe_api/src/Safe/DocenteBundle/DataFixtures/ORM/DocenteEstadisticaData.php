<?php
namespace Safe\DocenteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Safe\DocenteBundle\DataFixtures\ORM\DocenteData;
use Safe\DocenteBundle\Entity\Docente;
use Safe\AlumnoBundle\Entity\Alumno;
use Safe\CursoBundle\Entity\Curso;
use Safe\TemaBundle\Entity\Tema;
use Safe\TemaBundle\Entity\AlumnoEstadoTema;
use Safe\TemaBundle\Entity\AlumnoEstadoCurso;
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
        $docente = $this->getReference('docente1'); 
        
        $alumno1 = $this->crearAlumno('alumnoEst1', '1000');
        $manager->persist($alumno1->getUsuario());
        $manager->persist($alumno1);                
        $manager->flush();
        
        $alumno2 = $this->crearAlumno('alumnoEst2', '1001');
        $manager->persist($alumno2->getUsuario());
        $manager->persist($alumno2);                
        $manager->flush();
        
        $alumno3 = $this->crearAlumno('alumnoEst3', '1002');
        $manager->persist($alumno3->getUsuario());
        $manager->persist($alumno3);                
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
        
        $tema1 = $this->crearTema("100", $curso);
        $manager->persist($tema1);
        $manager->flush();
    
        $manager->persist(new AlumnoEstadoTema($alumno1, $tema1, true));
        $manager->persist(new AlumnoEstadoTema($alumno2, $tema1, true));
        $manager->flush();
        
        
        $tema2 = $this->crearTema("200", $curso, false);        
        $manager->persist($tema2);
        $manager->flush();
       
        $manager->persist(new AlumnoEstadoTema($alumno1, $tema2, true));
        $manager->flush();
     
        /*
            El curso tiene 3 alumno de los cuales solo termino el alumno 1
        */
        
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
}
