<?php

declare(strict_types=1);

namespace App\Exception;

/**
 * Class CannotRegisterUnderage.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CannotRegisterUnderage extends \DomainException
{
    public static function with(int $age): self
    {
        return new self(sprintf('Cannot register underage student, age %d is not allowed', $age));
    }
}
