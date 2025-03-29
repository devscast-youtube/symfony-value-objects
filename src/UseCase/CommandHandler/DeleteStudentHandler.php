<?php

namespace App\UseCase\CommandHandler;

use App\Repository\StudentRepository;
use App\UseCase\Command\UpdateStudentProfile;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler('command.bus')]
final readonly class DeleteStudentHandler
{
    public function __construct(
        private StudentRepository $studentRepository
    ) {
    }

    public function __invoke(UpdateStudentProfile $command): void
    {
        $student = $this->studentRepository->getById($command->studentId);
        $this->studentRepository->remove($student);
    }
}
