<?php
namespace Safe\AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

use Safe\PerfilBundle\Form\UsuarioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistracionDocenteType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', UsuarioType::class)
            ->add('curriculum', TextareaType::class)
            ->add('legajo', TextType::class)    
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\DocenteBundle\Entity\Docente',            
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
