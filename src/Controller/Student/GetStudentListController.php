<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\AbstractController;
use App\ReadModel\StudentList;
use App\UseCase\Query\GetStudentList;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class GetStudentListController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/student', name: 'app_student_index', methods: ['GET'])]
final class GetStudentListController extends AbstractController
{
    public function __invoke(): Response
    {
        /** @var StudentList $students */
        $students = $this->handleQuery(new GetStudentList());

        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }
}
