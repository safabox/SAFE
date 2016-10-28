<?php

namespace Safe\DocenteBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class DocenteFlatType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('curriculum', TextareaType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\DocenteBundle\Entity\Docente',
            'intention'  => 'registration',            
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
