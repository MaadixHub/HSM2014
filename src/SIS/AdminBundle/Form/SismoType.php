<?php

namespace SIS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SismoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('sismo')
			->add('anio')
			->add('mes')
			->add('dia')
			->add('hora')
			->add('minuto')
			->add('segundo')
            ->add('intensidadMaxima')
            ->add('intensidadEpicentral')
            ->add('magnitudEstimada')
            ->add('zonaMacrosismica')
            ->add('fenomenosAsociados', 'textarea', array('required' => false))
            ->add('resumenDanos', 'textarea', array('required' => false))
            ->add('bibliografia', 'textarea', array('required' => false))
            ->add('interpretacion', 'textarea', array('required' => false))
            ->add('citaTextual', 'textarea', array('required' => false))
            ->add('citaRepresentativa', 'textarea', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'sis_adminbundle_sismotype';
    }
}
