<?php
/**
 * Created by PhpStorm.
 * User: Geert
 * Date: 18/06/2016
 * Time: 19:49
 */

/**
 * http://symfony.com/doc/current/reference/forms/types/repeated.html
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ChangePasswordType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'label' => 'Huidig Wachtwoord'
            ))
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'De wachtwoordvelden komen niet overeen',
                'required' => true,
                'first_options'  => array('label' => 'Nieuw wachtwoord'),
                'second_options' => array('label' => 'Herhaal nieuw wachtwoord'),
            ));
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Model\ChangePassword',
        //    'data_class' => $this->class,
        ));
    }

    public function getName()
    {
        return 'change_password';
    }

}