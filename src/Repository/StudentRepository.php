<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\ValueObject\Email;
use App\Exception\EmailAlreadyUsed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function ensureEmailNotUsed(Email $email): void
    {
        $student = $this->findOneBy(['email_value' => $email->value]);

        if ($student !== null) {
            throw EmailAlreadyUsed::with($email);
        }
    }
}
