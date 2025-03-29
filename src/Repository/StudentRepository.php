<?php

namespace App\Repository;

use App\Entity\Student;
use App\Exception\StudentNotFound;
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

    public function add(Student $student): void
    {
        $this->getEntityManager()->persist($student);
        $this->getEntityManager()->flush();
    }

    public function remove(Student $student): void
    {
        $this->getEntityManager()->remove($student);
        $this->getEntityManager()->flush();
    }

    public function getById(int $studentId): Student
    {
        $student = $this->find($studentId);

        if ($student === null) {
            throw StudentNotFound::withId($studentId);
        }

        return $student;
    }
}
