<?php
namespace Safe\TemaBundle\Form\DataTransformer;

use Safe\TemaBundle\Entity\Concepto;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ConceptoAIdentificadorTransformer implements DataTransformerInterface
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
    public function transform($concepto)
    {
        if (null === $concepto) {
            return '';
        }

        return $concepto->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $issueNumber
     * @return Issue|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($idConcepto)
    {
        // no issue number? It's optional, so that's ok
        if (!$idConcepto) {
            return;
        }

        $concepto = $this->manager
            ->getRepository('SafeTemaBundle:Concepto')
            // query for the issue with this id
            ->find($idConcepto)
        ;

        if (null === $concepto) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $idConcepto
            ));
        }

        return $concepto;
    }
}