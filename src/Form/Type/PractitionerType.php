<?php

namespace GSB\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PractitionerType extends AbstractType {

    private $types;

    /**
     * Constructor.
     *
     * @param array $types
     */
    public function __construct($types) {
        $this->types = $types;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('type', 'choice', array(
                    'label' => "type",
                    'choices' => $this->types,
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => false  // this field is not mapped to an object property
                ))
                ->add('name', 'text', array('required' => TRUE))
                ->add('firstName', 'text', array('required' => TRUE))
                ->add('address', 'text', array('required' => TRUE))
                ->add('city', 'text', array('required' => TRUE))
                ->add('notorietyCoefficient', 'number', array('required' => TRUE))
                ->add('zipCode', 'text', array(
                    'required' => TRUE,
                    'constraints' => array(new \Symfony\Component\Validator\Constraints\Regex(array(
                            'pattern' => '#^[0-9]{5}$#',
                            'match' => TRUE,
                            'message' => 'Votre Code postal est incorrect'
                        )))))
                ->add('save', 'submit', array(
                    'label' => 'Enregistrer',
        ));
    }

    public function getName() {
        return 'practitioner';
    }

}
