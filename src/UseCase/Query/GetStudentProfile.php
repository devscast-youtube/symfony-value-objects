<?php

declare(strict_types=1);

namespace App\UseCase\Query;

/**
 * Class GetStudentProfile.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class GetStudentProfile
{
    public function __construct(
        public int $studentId
    ) {
    }
}
