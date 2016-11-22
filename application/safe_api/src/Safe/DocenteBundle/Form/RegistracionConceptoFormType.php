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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Doctrine\Common\Persistence\ObjectManager;

use Safe\TemaBundle\Form\IdentificadorConceptoType;
use Safe\CoreBundle\Form\BooleanType;
use Safe\CatBundle\Form\RegistracionItemBankType;
use Safe\CatBundle\Entity\ItemType;
use Safe\CatBundle\Entity\ThetaEstimationMethodType;

class RegistracionConceptoFormType extends AbstractType {
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titulo', TextType::class)
                ->add('copete', TextareaType::class)
                ->add('descripcion', TextareaType::class)
                ->add('orden', NumberType::class)
                ->add('habilitado', BooleanType::class)  
                ->add('mostrarResultado', BooleanType::class)
                ->add('predecesoras',  CollectionType::class, array(
                    'entry_type' => 'identificador_concepto',
                    'allow_add' => true,        
                    
                ))        
                ->add('tipo', ChoiceType::class, array(
                            'choices'  => array(
                                    ItemType::RASH => ItemType::RASH,
                                    ItemType::TWO_PL => ItemType::TWO_PL,
                                    ItemType::THREE_Pl => ItemType::THREE_Pl,                                
                            )
                ))
                ->add('rango', CollectionType::class, array(                
                    'entry_type'   => NumberType::class,
                    'allow_add' => true
                ))
                ->add('metodo', ChoiceType::class, 
                        array(
                            'choices'  => array(
                                    ThetaEstimationMethodType::THETA_MLE => ThetaEstimationMethodType::THETA_MLE,
                                    ThetaEstimationMethodType::THETA_NEWTON_RAPHSON => ThetaEstimationMethodType::THETA_NEWTON_RAPHSON,                                
                            )
                ))
                ->add('incremento', NumberType::class)
                ->add('expectativa', NumberType::class)
        ;
        
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\DocenteBundle\Form\ConceptoForm',          
            'allow_extra_fields' => true
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
