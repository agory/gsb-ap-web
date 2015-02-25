<?php

namespace GSB\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VisitReportType extends AbstractType
{
    private $practitioners;
    
    /**
     * Constructor.
     *
     * @param array $practitioners
     */
    public function __construct($practitioners)
    {
        $this->practitioners = $practitioners;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('practitioner', 'choice', array(
                'label' => "Praticien",
                'choices' => $this->practitioners,
                'expanded' => false, 
                'multiple' => false,
                'mapped' => false  // this field is not mapped to an object property
            ))
            ->add('date', 'date', array(
                'label' => "Date",
                'widget' => 'single_text',    // this field is rendered as a simple input of type 'date'
            ))
            ->add('purpose', 'textarea', array(
                'label' => "Motif",
                'attr' => array(
                    'rows' => '4',
                )
            ))
            ->add('assessment', 'textarea', array(
                'label' => "Bilan",
                'attr' => array(
                    'rows' => '4',
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Ajouter',
            ));
    }

    public function getName()
    {
        return 'visitReport';
    }
}
