<?php
namespace Safe\AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


use Doctrine\Common\Persistence\ObjectManager;

use Safe\DocenteBundle\Form\IdentificadorDocenteType;

class RegistracionCursoType extends AbstractType {
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titulo', TextType::class)
                ->add('descripcion', TextareaType::class)
                ->add('docentes',  CollectionType::class, array(
                    'entry_type' => 'identificador_docente',
                    'allow_add' => true,        
                    'required' => true,
                ))
                ->add('alumnos',  CollectionType::class, array(
                    'entry_type' => 'identificador_alumno',
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
            'data_class' => 'Safe\CursoBundle\Entity\Curso',            
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
