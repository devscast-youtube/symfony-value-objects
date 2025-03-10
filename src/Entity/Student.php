<?php

namespace App\Entity;

use App\Entity\ValueObject\Address;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Username;
use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private(set) ?int $id = null;

    #[ORM\Embedded(class: Email::class)]
    private(set) ?Email $email = null;

    #[ORM\Embedded(class: Username::class)]
    private(set) ?Username $username = null;

    #[ORM\Embedded(class: Address::class, columnPrefix: false)]
    private(set) Address $address;

    #[ORM\Column]
    private(set) ?\DateTimeImmutable $birthdate = null;

    public function __construct()
    {
        $this->address = new Address();
    }

    public function setEmail(string $email): static
    {
        $this->email = new Email($email);

        return $this;
    }

    public function setUsername(string $username): static
    {
        $this->username = new Username($username);

        return $this;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function setBirthdate(\DateTimeImmutable $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }
}
