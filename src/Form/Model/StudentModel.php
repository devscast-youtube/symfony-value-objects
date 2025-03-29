<?php

declare(strict_types=1);

namespace App\Form\Model;

use App\Entity\Student;
use App\Entity\ValueObject\Address;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Username;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StudentModel.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class StudentModel
{
    public function __construct(
        public ?Email $email = null,
        public ?Username $username = null,
        public Address $address = new Address(),
        #[Assert\LessThan('today')]
        public ?\DateTimeImmutable $birthdate = null
    ) {
    }

    public static function createFromEntity(Student $student): self
    {
        return new self(
            $student->email,
            $student->username,
            $student->address,
            $student->birthdate
        );
    }
}
