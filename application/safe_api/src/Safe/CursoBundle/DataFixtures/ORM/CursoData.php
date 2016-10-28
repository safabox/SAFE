<?php
namespace Safe\CursoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Safe\CursoBundle\Entity\Curso;

class CursoData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $curso = new Curso();
        $curso->setInstituto($this->getReference('instituto'));
        $curso->setTitulo('Matematicas');
        $curso->setDescripcion('Curso de matematicas');
        $curso->setDocentes(array($this->getReference('docente1')));
        $curso->setAlumnos(array($this->getReference('alumno1'), $this->getReference('alumno2'), $this->getReference('alumno3')));
        

        $manager->persist($curso);
        
        $curso2 = new Curso();
        $curso2->setInstituto($this->getReference('instituto'));
        $curso2->setTitulo('Lengua');
        $curso2->setDescripcion('Curso de lengua');
        $curso2->setDocentes(array($this->getReference('docente1')));
        $curso2->setAlumnos(array($this->getReference('alumno1'), $this->getReference('alumno2'), $this->getReference('alumno3')));
        

        $manager->persist($curso2);

        $manager->flush();

        $this->addReference('curso-matematicas', $curso);
        $this->addReference('curso-lenguas', $curso2);
    }

    public function getOrder() {
        return 6;
    }

}
