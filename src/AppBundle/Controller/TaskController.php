<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('task/index.html.twig');
    }

    /**
     * @Route("/taskstodo", name="task_todo_list")
     */
    public function listToDoAction()
    {
        $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')
                      ->findBy(
                          array('isDone' => false),
                          array('createdAt' => 'desc'),
                          null,
                          null
                      );

        return $this->render('task/list.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @Route("/tasksdone", name="task_done_list")
     */
    public function listDoneAction()
    {
        $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')
                      ->findBy(
                          array('isDone' => true),
                          array('createdAt' => 'desc'),
                          null,
                          null
                      );

        return $this->render('task/list.html.twig', array(
            'tasks' => $tasks,
        ));
    }
    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $task->setUser($this->getUser());
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_todo_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
       $this->denyAccessUnlessGranted('EDIT', $task);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_todo_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_todo_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('DELETE', $task);

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_todo_list');
    }
}
