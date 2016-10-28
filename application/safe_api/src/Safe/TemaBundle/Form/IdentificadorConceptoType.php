<?php

namespace Safe\TemaBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;


use Safe\TemaBundle\Form\DataTransformer\ConceptoAIdentificadorTransformer;

use Doctrine\Common\Persistence\ObjectManager;


class IdentificadorConceptoType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ConceptoAIdentificadorTransformer($this->manager));
    }

    /**
     * @param OptionsResolver $resolver
     */
    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\DocenteBundle\Entity\Docente',            
        ));
    }*/
    public function getParent()
    {
        return TextType::class;
    }


    public function getName()
    {
        return 'identificador_concepto';
    }
}
