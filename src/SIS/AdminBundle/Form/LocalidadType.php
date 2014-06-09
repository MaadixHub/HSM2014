<?php

namespace SIS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LocalidadType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('localidad')
			->add('nombreOficial')
            ->add('latitud')
            ->add('longitud')
            ->add('estado')
        ;
    }

    public function getName()
    {
        return 'sis_adminbundle_localidadtype';
    }
}
