<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Address.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Embeddable]
final class Address
{
    public function __construct(
        #[Column(length: 255)]
        #[Assert\NotBlank()]
        public ?string $city = null,
        #[Column(length: 255)]
        #[Assert\Country()]
        public ?string $country = null,
        #[Column(length: 255)]
        #[Assert\NotBlank()]
        public ?string $addressLine1 = null,
        #[Column(length: 255, nullable: true)]
        public ?string $addressLine2 = null
    ) {
    }
}
