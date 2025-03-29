<?php

declare(strict_types=1);

namespace App\Exception;

/**
 * Class StudentNotFound.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class StudentNotFound extends \DomainException
{
    public static function withId(int $studentId): self
    {
        return new self(sprintf('Student with id %d not found', $studentId));
    }
}
