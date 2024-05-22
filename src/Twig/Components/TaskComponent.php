<?php

namespace App\Twig\Components;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('Task', template: 'components/TaskComponent.html.twig')]
class TaskComponent
{
    public function __construct(private TaskRepository $taskRepository,)
    {
    }

    use DefaultActionTrait;

    #[LiveProp]
    public bool $isEditing = false;

    #[LiveProp(writable: ['done', 'description'])]
    public Task $task;

    #[LiveAction]
    public function activateEditing()
    {
        $this->isEditing = true;
    }
    #[LiveAction]
    public function save(): void
    {
        $this->isEditing = false;
        $this->taskRepository->persist($this->task);
    }
}