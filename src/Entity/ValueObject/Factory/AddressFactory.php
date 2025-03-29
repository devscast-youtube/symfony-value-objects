<?php

declare(strict_types=1);

namespace App\Entity\ValueObject\Factory;

use App\Entity\ValueObject\Address;
use Symfony\Component\Intl\Countries;
use Webmozart\Assert\Assert;

/**
 * Class AddressFactory.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class AddressFactory
{
    public function create(
        ?string $city = null,
        ?string $country = null,
        ?string $addressLine1 = null,
        ?string $addressLine2 = null
    ): Address {
        Assert::notEmpty($city, 'City cannot be empty');
        Assert::notEmpty($country, 'Country cannot be empty');
        Assert::notEmpty($addressLine1, 'Address line 1 cannot be empty');
        Assert::nullOrNotEmpty($addressLine2, 'Address line 2 cannot be empty');

        if (! Countries::alpha3CodeExists($country) && ! Countries::exists($country)) {
            throw new \InvalidArgumentException('invalid_country');
        }

        return new Address($city, $country, $addressLine1, $addressLine2);
    }
}
