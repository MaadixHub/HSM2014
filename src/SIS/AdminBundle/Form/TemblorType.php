<?php

namespace SIS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TemblorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
//            ->add('puntos')
            ->add('sismo')
            ->add('localidad')
			->add('intensidad')
			->add('comentario', 'textarea', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'sis_adminbundle_temblortype';
    }
}
