<?php

namespace App\MessageHandler;

use App\Entity\Student;
use App\Entity\ValueObject\Email;
use App\Exception\CannotRegisterUnderage;
use App\Exception\EmailAlreadyUsed;
use App\Message\AddStudent;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class AddStudentHandler
{
    private const int MAJORITY_THRESHOLD = 18;

    public function __construct(
        private StudentRepository $studentRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(AddStudent $message): void
    {
        $this->assertEmailNotUsed($message->email);
        $this->assertNotUnderage($message->birthdate);

        $student = new Student(
            $message->email,
            $message->username,
            $message->address,
            $message->birthdate
        );

        $this->entityManager->persist($student);
        $this->entityManager->flush();
    }

    private function assertEmailNotUsed(Email $email): void
    {
        $used = $this->studentRepository->findOneBy(['email.value' => (string) $email]);
        if ($used !== null) {
            throw EmailAlreadyUsed::with($email);
        }
    }

    private function assertNotUnderage(\DateTimeImmutable $birthdate): void
    {
        $age = new \DateTimeImmutable()->diff($birthdate)->y;
        if ($age < self::MAJORITY_THRESHOLD) {
            throw CannotRegisterUnderage::with($age);
        }
    }
}
