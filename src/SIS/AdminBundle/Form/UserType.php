<?php

namespace SIS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', 'repeated', array('type' => 'password', 'options' => array('label' => ' '),
                'invalid_message' => 'Las dos contraseñas deben coincidir'))
        //    ->add('salt')
            ->add('user_roles')
        ;
    }

    public function getName()
    {
        return 'sis_adminbundle_usertype';
    }
}
