<?php

namespace App\UseCase\Command;

use App\Entity\ValueObject\Address;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Username;

final readonly class AddStudent
{
    public function __construct(
        public Email $email,
        public Username $username,
        public Address $address,
        public \DateTimeImmutable $birthdate
    ) {
    }
}
