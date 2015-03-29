<?php

namespace Universibo\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('phone', null, [
                'label' => 'Cellulare'
            ])
            ->add('notifications', 'choice', [
                'label' => 'Livello di notifica',
                'choices' => [
                    0 => 'Nessuna',
                    1 => 'Solo urgenti',
                    2 => 'Tutte'
                ]
            ])
            ->add('contacts', 'collection', [
                'type' => new ContactType(),
                'prototype' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Contatti'
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Universibo\Bundle\CoreBundle\Entity\User'
        ]);
    }

    public function getName()
    {
        return 'universibo_bundle_corebundle_usertype';
    }
}
