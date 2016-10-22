<?php
namespace Safe\CatBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Safe\CatBundle\Entity\ItemType;
use Safe\CatBundle\Entity\ThetaEstimationMethodType;

use Doctrine\Common\Persistence\ObjectManager;

use Safe\TemaBundle\Form\IdentificadorConceptoType;
use Safe\CoreBundle\Form\BooleanType;

class RegistracionItemBankType extends AbstractType {
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tipo', CollectionType::class, array(
                            'choices'  => array(
                                    ItemType::RASH => ItemType::RASH,
                                    ItemType::TWO_PL => ItemType::TWO_PL,
                                    ItemType::THREE_Pl => ItemType::THREE_Pl,                                
                            ),
                            'property_path' => 'itemType'
                ))
                ->add('rango', CollectionType::class, array(                
                    'entry_type'   => NumberType::class,
                    'allow_add' => true,
                    'property_path' => 'itemRange'
                ))
                ->add('metodo', ChoiceType::class, 
                        array(
                            'choices'  => array(
                                    ThetaEstimationMethodType::THETA_MLE => ThetaEstimationMethodType::THETA_MLE,
                                    ThetaEstimationMethodType::THETA_NEWTON_RAPHSON => ThetaEstimationMethodType::THETA_NEWTON_RAPHSON,                                
                            ),
                            'property_path' => 'thetaEstimationMethod'
                        ))
                ->add('incremento', NumberType::class, array('property_path' => 'discretIncrement'))  
        ;
        
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Safe\CatBundle\Entity\ItemBank',            
        ));
    }
    
    public function getName()
    {
        return '';
    }
}
