<?php

namespace Safe\PerfilBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Safe\PerfilBundle\Entity\Usuario;
class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('apellido', TextType::class)
            ->add('avatar', TextType::class)
                
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('roles', CollectionType::class, array(
                
                'entry_type'   => ChoiceType::class,
                'entry_options'  => array(
                        'choices'  => array(
                                'ROLE_SUPERVISOR' => 'ROLE_SUPERVISOR',
                                'ROLE_ALUMNO'     => 'ROLE_ALUMNO',
                                'ROLE_DOCENTE'    => 'ROLE_DOCENTE',                                
                        )
                ),
                'allow_add' => true,
            ))    
            /*->add('roles', ChoiceType::class, array(
                'roles' => array(
                    'ROLE_SUPERVISOR' => ['ROLE_SUPERVISOR'],
                    'ROLE_ALUMNO' => ['ROLE_ALUMNO'],
                    'ROLE_DOCENTE' => ['ROLE_DOCENTE'],                    
                )
            ))*/    
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\PerfilBundle\Entity\Usuario',
            'intention'  => 'registration',
            'constraints' => array(
                new UniqueEntity(array('fields' => array('username'))),
                new UniqueEntity(array('fields' => array('email')))              
            )
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
