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
        

        $manager->persist($curso);

        $manager->flush();

        $this->addReference('curso-matematicas', $curso);
    }

    public function getOrder() {
        return 5;
    }

}
