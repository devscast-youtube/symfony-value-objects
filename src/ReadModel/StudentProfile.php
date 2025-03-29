<?php

declare(strict_types=1);

namespace App\ReadModel;

use App\Entity\ValueObject\Address;
use App\Entity\ValueObject\Age;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Username;

/**
 * Class StudentProfile.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class StudentProfile
{
    public function __construct(
        public int $id,
        public Username $username,
        public Email $email,
        public Address $address,
        public Age $age
    ) {
    }
}
