<?php

namespace GSB\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VisitorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', 'text', array(
                'label' => "Nom",
            ))
            ->add('firstName', 'text', array(
                'label' => "Prénom",
            ))
            ->add('address', 'text', array(
                'label' => "Adresse",
            ))
            ->add('zipCode', 'text', array(
                'label' => "Code postal",
            ))
            ->add('city', 'text', array(
                'label' => "Ville",
            ))
            ->add('hiringDate', 'date', array(
                'label' => "Date d'embauche",
                'widget' => 'single_text',    // this field is rendered as a simple input of type 'date'
            ))
            ->add('username', 'text', array(
                'label' => "Nom d'utilisateur",
            ))
            ->add('password', 'password', array(
                'label' => 'Mot de passe',
            ))
            ->add('save', 'submit', array(
                'label' => 'Mettre à jour',
            ));
    }

    public function getName()
    {
        return 'visitor';
    }
}
