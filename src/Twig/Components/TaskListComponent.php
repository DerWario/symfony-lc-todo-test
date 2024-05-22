<?php

namespace App\Twig\Components;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('TaskList', template: 'components/TaskListComponent.html.twig')]
class TaskListComponent
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    public function __construct(
        private TaskRepository $taskRepository,
    )
    {
    }

    /** @var Task[]  */
    #[LiveProp]
    public array $tasks;

    #[LiveProp]
    public bool $isAddingTask = false;

    #[LiveProp(writable: true)]
    public string $newTaskDescription = '';

    #[LiveAction]
    public function activateAddTask()
    {
        $this->isAddingTask = true;
    }

    #[LiveAction]
    public function addNewTask()
    {
        $task = new Task();
        dump($this->newTaskDescription);
        $task->setDescription($this->newTaskDescription);
        $task->setDone(false);
        $this->taskRepository->persist($task);

        $this->tasks[] = $task;

        $this->isAddingTask = false;
        $this->newTaskDescription = '';
        $this->emit('$render');
    }

}