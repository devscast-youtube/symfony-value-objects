<?php

namespace App\Controller\Student;

use App\Controller\AbstractController;
use App\Exception\StudentNotFound;
use App\ReadModel\StudentProfile;
use App\UseCase\Query\GetStudentProfile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/student/{id}', name: 'app_student_show', requirements: [
    'id' => Requirement::DIGITS,
], methods: ['GET'])]
final class GetStudentProfileController extends AbstractController
{
    public function __invoke(int $id): Response
    {
        try {
            /** @var StudentProfile $student */
            $student = $this->handleQuery(new GetStudentProfile($id));
        } catch (StudentNotFound) {
            throw $this->createNotFoundException();
        }

        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }
}
