<?php

namespace App\Console;

use App\Bus\QueryBus;
use App\ReadModel\StudentList;
use App\ReadModel\StudentProfile;
use App\UseCase\Query\GetStudentList;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:list-student',
    description: 'List all student'
)]
class GetStudentListConsole extends Command
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            /** @var StudentList $students */
            $students = $this->queryBus->handle(new GetStudentList());

            if (false === $students->isEmpty()) {
                $io->table(
                    ['id', 'age', 'username', 'email', 'city', 'country', 'line1', 'line2'],
                    array_map(fn (StudentProfile $item) => [
                        $item->id,
                        $item->age->value,
                        $item->username->value,
                        $item->email->value,
                        $item->address->city,
                        $item->address->country,
                        $item->address->addressLine1,
                        $item->address->addressLine2
                    ], $students->items)
                );
            } else {
                $io->warning('Student list is empty');
            }
        } catch (\DomainException $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
