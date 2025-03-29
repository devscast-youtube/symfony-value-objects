<?php

namespace App\UseCase\Command;

final readonly class DeleteStudent
{
    public function __construct(
        public int $studentId
    ) {
    }
}
