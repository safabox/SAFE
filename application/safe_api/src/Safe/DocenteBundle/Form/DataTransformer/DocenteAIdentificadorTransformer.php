<?php
namespace Safe\DocenteBundle\Form\DataTransformer;

use Safe\DocenteBundle\Entity\Docente;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DocenteAIdentificadorTransformer implements DataTransformerInterface
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
    public function transform($docente)
    {
        if (null === $docente) {
            return '';
        }

        return $docente->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $issueNumber
     * @return Issue|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($idDocente)
    {
        // no issue number? It's optional, so that's ok
        if (!$idDocente) {
            return;
        }

        $docente = $this->manager
            ->getRepository('SafeDocenteBundle:Docente')
            // query for the issue with this id
            ->find($idDocente)
        ;

        if (null === $docente) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $idDocente
            ));
        }

        return $docente;
    }
}