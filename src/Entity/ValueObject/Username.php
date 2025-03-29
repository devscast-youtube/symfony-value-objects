<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

/**
 * Class Username.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Embeddable]
final readonly class Username implements \Stringable
{
    private const int MIN = 3;

    private const int MAX = 20;

    #[Column(type: 'string')]
    public string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::lengthBetween($value, self::MIN, self::MAX);

        $this->value = $value;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->value;
    }
}
