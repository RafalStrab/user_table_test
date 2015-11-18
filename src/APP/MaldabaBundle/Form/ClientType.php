<?php

namespace APP\MaldabaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'choice', array(
                'choices'  => array(
                    'Miss' => 'Miss',
                    'Mr'   => 'Mr',
                    'Mrs'  => 'Mrs',
                ),
                'placeholder' => 'Choose your title',
                'empty_data'  => null,
                'label' => 'Title:'
            ))
            ->add('firstName', null, array(
                'label' => 'First Name:',
            ))
            ->add('surname', null, array(
                'label' => 'Surname:',
            ))
            ->add('dateOfBirth', 'birthday', array(
                'label' => 'Date of Birth:',
                'placeholder' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),
            ))
            ->add('email', 'email', array(
                'label' => 'E-mail:',
            ))
            ->add('mobilePhone', null, array(
                'label' => 'Mobile Phone:',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'APP\MaldabaBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_maldababundle_client';
    }
}
