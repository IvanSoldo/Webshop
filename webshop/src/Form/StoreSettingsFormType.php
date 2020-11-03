<?php

namespace App\Form;

use App\Entity\StoreSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreSettingsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('storeName', null, ['required'   => false,'empty_data' => '',])
            ->add('email',null, ['required'   => false,'empty_data' => '',])
            ->add('newProductsDate', DateType::class,[
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => null,
                'attr' => array(
                    'placeholder' => 'mm/dd/yyyy')
            ])
            ->add('address', AddressType::class, [
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StoreSettings::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }
}
