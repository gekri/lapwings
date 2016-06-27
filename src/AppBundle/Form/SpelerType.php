<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpelerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voornaam')
            ->add('achternaam')
            ->add('geboortedatum', DateType::class, array(
                'widget' =>'single_text',
                'html5' => false,
            ))
            ->add('aansluitingsdatum', DateType::class, array(
                'widget' =>'single_text',
                'html5' => false,
            ))
            ->add('aansluitingsnummer')
            ->add('eindeAansluiting', DateType::class, array(
                'widget' =>'single_text',
                'html5' => false,
                'required' => false,
            ))
            ->add('file', FileType::class, array(
                'required' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Speler'
        ));
    }
}
