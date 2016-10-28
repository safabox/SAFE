<?php
namespace Safe\AlumnoBundle\Form\DataTransformer;

use Safe\AlumnoBundle\Entity\Alumno;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AlumnoAIdentificadorTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($alumno)
    {
        if (null === $alumno) {
            return '';
        }

        return $alumno->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $issueNumber
     * @return Issue|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($idAlumno)
    {
        // no issue number? It's optional, so that's ok
        if (!$idAlumno) {
            return;
        }

        $alumno = $this->manager
            ->getRepository('SafeAlumnoBundle:Alumno')
            // query for the issue with this id
            ->find($idAlumno)
        ;

        if (null === $alumno) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $alumno
            ));
        }

        return $alumno;
    }
}