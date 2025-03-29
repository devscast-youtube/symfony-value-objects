<?php

namespace App\UseCase\CommandHandler;

use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Service\AgeVerifier;
use App\Service\EmailVerifier;
use App\UseCase\Command\AddStudent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler('command.bus')]
final readonly class AddStudentHandler
{
    public function __construct(
        private AgeVerifier $ageVerifier,
        private EmailVerifier $emailVerifier,
        private StudentRepository $studentRepository
    ) {
    }

    public function __invoke(AddStudent $command): void
    {
        $this->emailVerifier->assertNotUsed($command->email);
        $this->ageVerifier->assertNotUnderage($command->birthdate);

        $student = new Student(
            $command->email,
            $command->username,
            $command->address,
            $command->birthdate
        );

        $this->studentRepository->add($student);
    }
}
