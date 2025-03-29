<?php

namespace App\Controller\Student;

use App\Controller\AbstractController;
use App\Entity\Student;
use App\UseCase\Command\DeleteStudent;
use DomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student/{id}', name: 'app_student_delete', methods: ['POST'])]
final class DeleteStudentController extends AbstractController
{
    public function __invoke(Request $request, Student $student): Response
    {
        if ($this->isCsrfTokenValid('delete' . $student->id, $request->getPayload()->getString('_token'))) {
            try {
                $this->handleCommand(new DeleteStudent($student->id));
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }
}
