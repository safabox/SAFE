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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\ORM\EntityRepository;

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
            ->add('enabled', CheckboxType::class)            
            ->add('numeroDocumento', TextType::class)
            ->add('genero', TextType::class)
            ->add('tipoDocumento', EntityType::class, array(
                'class' => 'SafePerfilBundle:TipoDocumento',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('tipoDocumento')
                              ->orderBy('tipoDocumento.codigo', 'ASC');
                },
                'choice_label' => 'codigo', 
                'choice_value' => 'codigo',        
            ))        
                
            ->add('textPassword', 'repeated', array(
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
                                Usuario::ROLE_SUPERVISOR => Usuario::ROLE_SUPERVISOR,
                                Usuario::ROLE_DOCENTE   => Usuario::ROLE_DOCENTE,
                                Usuario::ROLE_ALUMNO    => Usuario::ROLE_ALUMNO,                                
                        )
                ),
                'allow_add' => true,
            ))            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\PerfilBundle\Entity\Usuario',            
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
