<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * $manager construct
     *
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/tasks", name="task_list")
     */
    public function taskList(TaskRepository $taskRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('task/list.html.twig', [
            'tasks' => $taskRepository->findBy([], ['createdAt' => 'DESC'])
        ]);
    }

    /**
     * @Route("/tasks_done", name="task_list_done")
     */
    public function taskListDone(TaskRepository $taskRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('task/list.html.twig', [
            'tasks' => $taskRepository->findBy(['isDone' => true])
        ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function taskCreate(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $task = new Task();
        $task->setUser($this->getUser());
        $task->setCreatedAt(new \Datetime());
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function taskEdit(Task $task, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function taskToggle(Task $task)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function taskDelete(Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
