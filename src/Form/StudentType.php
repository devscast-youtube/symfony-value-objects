<?php

namespace App\Form;

use App\Form\Model\StudentModel;
use App\Form\Types\AddressType;
use App\Form\Types\EmailType;
use App\Form\Types\UsernameType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('username', UsernameType::class)
            ->add('address', AddressType::class)
            ->add('birthdate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentModel::class,
        ]);
    }
}
