<?php
namespace Safe\AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\Common\Persistence\ObjectManager;

use Safe\DocenteBundle\Form\DataTransformer\DocenteToNumberTransformer;

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
                ->add('docente', TextType::class)
        ;
        
        $builder->get('docente')->addModelTransformer(new DocenteToNumberTransformer($this->manager));
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
