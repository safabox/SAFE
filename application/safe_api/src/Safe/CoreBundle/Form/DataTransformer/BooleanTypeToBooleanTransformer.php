<?php
namespace Safe\CoreBundle\Form\DataTransformer;

use Safe\CoreBundle\Form\BooleanType;
use Symfony\Component\Form\DataTransformerInterface;
class BooleanTypeToBooleanTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (true === $value || BooleanType::VALUE_TRUE === (int) $value) {
            return BooleanType::VALUE_TRUE;
        }
        return BooleanType::VALUE_FALSE;
    }
    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (BooleanType::VALUE_TRUE === (int) $value) {
            return true;
        }
        return false;
    }
}