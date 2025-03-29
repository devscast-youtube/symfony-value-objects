<?php

declare(strict_types=1);

namespace App\Exception;

use App\Entity\ValueObject\Email;

final class EmailAlreadyUsed extends \DomainException
{
    public static function with(Email $email): self
    {
        return new self(sprintf('Email %s is already used', $email));
    }
}
