<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ValueObject\Email;
use App\Exception\EmailAlreadyUsed;
use App\Repository\StudentRepository;

/**
 * Class EmailVerifier.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class EmailVerifier
{
    public function __construct(
        private StudentRepository $studentRepository
    ) {
    }

    public function assertNotUsed(Email $email): void
    {
        $used = $this->studentRepository->findOneBy([
            'email.value' => (string) $email,
        ]);

        if ($used !== null) {
            throw EmailAlreadyUsed::with($email);
        }
    }
}
