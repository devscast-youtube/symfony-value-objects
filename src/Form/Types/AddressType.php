<?php

declare(strict_types=1);

namespace App\Form\Types;

use App\Entity\ValueObject\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddressType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class)
            ->add('country', CountryType::class)
            ->add('addressLine1', TextType::class)
            ->add('addressLine2', TextType::class, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => Address::class,
            'empty_data' => null
        ]);

        return $resolver;
    }
}
