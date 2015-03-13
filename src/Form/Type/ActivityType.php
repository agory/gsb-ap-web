<?php

namespace GSB\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date', array(
                'widget' => 'single_text', // this field is rendered as a simple input of type 'date'
                'format' => 'yyyy-MM-dd',
                'required' => true,
            ))
            ->add('place', 'text', array(
                'attr' => array(
                    'placeholder' => 'Entrer le lieu de l\'activité',
                    'required' => true,
            )))
            ->add('theme', 'text', array(
                'attr' => array(
                    'placeholder' => 'Entrer le thème de l\'activité',
                    'required' => true,
            )))
            ->add('purpose', 'text', array(
                'attr' => array(
                    'placeholder' => 'Entrer la raison de l\'activité',
                    'required' => true,
            )))
            ->add('save', 'submit', array(
                'label' => 'Enregistrer',
            ));
    }

    public function getName()
    {
        return 'activity';
    }
}
