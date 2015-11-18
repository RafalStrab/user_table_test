<?php

namespace APP\MaldabaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientAddressType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('line1')
            ->add('line2')
            ->add('postcode')
            ->add('country')
            ->add('city')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'APP\MaldabaBundle\Entity\ClientAddress'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_maldababundle_clientaddress';
    }
}
