<?php
namespace Safe\AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class RegistracionInstitutoType extends AbstractType {
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('razonSocial', TextType::class)
                ->add('descripcion', TextareaType::class)
        ;
        
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\InstitutoBundle\Entity\Instituto',            
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
