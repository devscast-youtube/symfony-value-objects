<?php

namespace App\UseCase\CommandHandler;

use App\Repository\StudentRepository;
use App\Service\AgeVerifier;
use App\Service\EmailVerifier;
use App\UseCase\Command\UpdateStudentProfile;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler('command.bus')]
final readonly class UpdateStudentProfileHandler
{
    public function __construct(
        private AgeVerifier $ageVerifier,
        private EmailVerifier $emailVerifier,
        private StudentRepository $studentRepository
    ) {
    }

    public function __invoke(UpdateStudentProfile $command): void
    {
        $student = $this->studentRepository->getById($command->studentId);

        if ($student->email->equals($command->email) === false) {
            $this->emailVerifier->assertNotUsed($command->email);
        }

        if ($student->birthdate != $command->birthdate) {
            $this->ageVerifier->assertNotUnderage($command->birthdate);
        }

        $student->updateProfile(
            $command->email,
            $command->username,
            $command->address,
            $command->birthdate
        );

        $this->studentRepository->add($student);
    }
}
