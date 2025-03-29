<?php

declare(strict_types=1);

namespace App\Form\Types;

use App\Entity\ValueObject\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType as SymfonyEmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EmailType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class EmailType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', SymfonyEmailType::class, [
            'label' => 'email',
            'attr' => [
                'placeholder' => 'exemple bernard@devscast.tech',
            ],
        ])->setDataMapper($this);
    }

    /**
     * @see https://github.com/symfony/symfony/issues/59950
     */
    #[\Override]
    public function getBlockPrefix(): string
    {
        return '';
    }

    public function configureOptions(OptionsResolver $resolver): OptionsResolver
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => Email::class,
            'empty_data' => null,
        ]);

        return $resolver;
    }

    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        $forms = iterator_to_array($forms);
        $forms['email']->setData((string) $viewData);
    }

    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);
        try {
            $viewData = new Email($forms['email']->getData());
        } catch (\InvalidArgumentException $e) {
            $forms['email']->addError(new FormError($e->getMessage()));
        }
    }
}
