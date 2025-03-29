<?php

declare(strict_types=1);

namespace App\Form\Types;

use App\Entity\ValueObject\Address;
use App\Entity\ValueObject\Factory\AddressFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddressType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AddressType extends AbstractType implements DataMapperInterface
{
    public function __construct(
        private readonly AddressFactory $addressFactory
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class)
            ->add('country', CountryType::class)
            ->add('addressLine1', TextType::class)
            ->add('addressLine2', TextType::class, [
                'required' => false,
            ])
            ->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => Address::class,
            'empty_data' => null,
        ]);

        return $resolver;
    }

    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['city']->setData($viewData?->city);
        $forms['country']->setData($viewData?->country);
        $forms['addressLine1']->setData($viewData?->addressLine1);
        $forms['addressLine2']->setData($viewData?->addressLine2);
    }

    /**
     * @param \Traversable<FormInterface> $forms
     */
    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);

        try {
            $viewData = $this->addressFactory->create(
                $forms['city']->getData(),
                $forms['country']->getData(),
                $forms['addressLine1']->getData(),
                $forms['addressLine2']->getData()
            );
        } catch (\InvalidArgumentException $e) {
            // adding all error to the city field
            // you can create custom exception for each field
            // and map it to the right field
            $forms['city']->addError(new FormError($e->getMessage()));
        }
    }
}
