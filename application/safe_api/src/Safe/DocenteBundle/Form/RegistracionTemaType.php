<?php
namespace Safe\DocenteBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


use Doctrine\Common\Persistence\ObjectManager;

use Safe\TemaBundle\Form\IdentificadorTemaType;
use Safe\CoreBundle\Form\BooleanType;

class RegistracionTemaType extends AbstractType {
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titulo', TextType::class)
                ->add('descripcion', TextareaType::class)
                ->add('orden', NumberType::class)
                ->add('habilitado', BooleanType::class)  
                ->add('predecesoras',  CollectionType::class, array(
                    'entry_type' => 'identificador_tema',
                    'allow_add' => true,        
                    
                ))
                ->add('sucesoras',  CollectionType::class, array(
                    'entry_type' => 'identificador_tema',
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
            'data_class' => 'Safe\TemaBundle\Entity\Tema',            
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
