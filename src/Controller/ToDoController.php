<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class ToDoController extends AbstractController
{
    public function __construct(
        private TaskRepository $taskRepository,
    )
    {
    }

    public function __invoke(): Response
    {
        return $this->render('index.html.twig', [
            'tasks' => $this->taskRepository->findAll(),
        ]);
    }
}
