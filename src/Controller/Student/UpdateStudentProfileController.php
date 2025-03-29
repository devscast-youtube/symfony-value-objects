<?php

namespace App\Controller\Student;

use App\Controller\AbstractController;
use App\Entity\Student;
use App\Form\Model\StudentModel;
use App\Form\StudentType;
use App\UseCase\Command\UpdateStudentProfile;
use DomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
final class UpdateStudentProfileController extends AbstractController
{
    public function __invoke(Request $request, Student $student): Response
    {
        $model = StudentModel::createFromEntity($student);
        $form = $this->createForm(StudentType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handleCommand(new UpdateStudentProfile(
                    $student->id,
                    $model->email,
                    $model->username,
                    $model->address,
                    $model->birthdate
                ));
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());

                return $this->redirectToRoute('app_student_edit', [
                    'id' => $student->id,
                ], Response::HTTP_SEE_OTHER);
            }

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }
}
