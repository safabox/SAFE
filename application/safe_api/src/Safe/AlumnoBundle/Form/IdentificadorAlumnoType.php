<?php

namespace Safe\AlumnoBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Safe\AlumnoBundle\Form\DataTransformer\AlumnoAIdentificadorTransformer;

use Doctrine\Common\Persistence\ObjectManager;


class IdentificadorAlumnoType extends AbstractType
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
        $builder->addModelTransformer(new AlumnoAIdentificadorTransformer($this->manager));
    }
    
    public function getParent()
    {
        return TextType::class;
    }


    public function getName()
    {
        return 'identificador_alumno';
    }
}
