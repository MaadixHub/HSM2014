<?php

namespace SIS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ZonaMacrosismicaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('zonaMacrosismica')
        ;
    }

    public function getName()
    {
        return 'sis_adminbundle_zonamacrosismicatype';
    }
}
