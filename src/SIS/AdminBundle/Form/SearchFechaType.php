<?php

namespace SIS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SismoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fecha', 'birthday', array(
			'years' => range(date('Y'), date('Y')-300), 'invalid_message' => 'La fecha indicada no es valida'
			))
        ;
    }

    public function getName()
    {
        return 'sis_adminbundle_sismotype';
    }
}
