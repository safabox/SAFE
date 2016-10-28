<?php

namespace Safe\PerfilBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Safe\PerfilBundle\Form\UsuarioType;
use Safe\AlumnoBundle\Form\AlumnoFlatType;
use Safe\DocenteBundle\Form\DocenteFlatType;

class RegistracionUsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', UsuarioType::class)
            ->add('alumno', AlumnoFlatType::class)
            ->add('docente', DocenteFlatType::class)    
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\PerfilBundle\Form\Model\RegistracionUsuario',            
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
