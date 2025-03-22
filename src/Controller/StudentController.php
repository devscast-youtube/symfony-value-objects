<?php

namespace App\Controller;

use App\DTO\StudentModel;
use App\Entity\Student;
use App\Entity\ValueObject\Email;
use App\Exception\CannotRegisterUnderage;
use App\Exception\EmailAlreadyUsed;
use App\Form\StudentType;
use App\Message\AddStudent;
use App\MessageBus;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student')]
final class StudentController extends AbstractController
{
    public function __construct(
       private readonly MessageBus $messageBus
    ) {
    }

    #[Route(name: 'app_student_index', methods: ['GET'])]
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $model = new StudentModel();
        $form = $this->createForm(StudentType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->messageBus->handle(new AddStudent(
                    $model->email,
                    $model->username,
                    $model->address,
                    $model->birthdate
                ));
            } catch (\DomainException $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('app_student_new', [], Response::HTTP_SEE_OTHER);
            }
            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/new.html.twig', [
            'student' => $model,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_show', methods: ['GET'])]
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        $model = StudentModel::createFromEntity($student);
        $form = $this->createForm(StudentType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student->updateProfile(
                $model->email,
                $model->username,
                $model->address,
                $model->birthdate
            );
            $entityManager->flush();

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_delete', methods: ['POST'])]
    public function delete(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->id, $request->getPayload()->getString('_token'))) {
            $entityManager->remove($student);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }
}
