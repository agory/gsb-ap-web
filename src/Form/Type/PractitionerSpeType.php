<?php

namespace GSB\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PractitionerSpeType extends AbstractType {

    private $spe;

    /**
     * Constructor.
     *
     * @param array $spe
     */
    public function __construct($spe) {
        $this->spe = $spe;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('spe', 'choice', array(
                    'label' => "Spécialité",
                    'choices' => $this->spe,
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false  // this field is not mapped to an object property
                ))
                ->add('save', 'submit', array(
                    'label' => 'Enregistrer',
        ));
    }

    public function getName() {
        return 'practitioner';
    }

}
