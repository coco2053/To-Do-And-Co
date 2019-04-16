<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TaskController.
 *
 * @codeCoverageIgnore
 */
class TaskController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        $response = $this->render('task/index.html.twig');
        $response->setSharedMaxAge(200);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @Route("/taskstodo", name="task_todo_list")
     *
     * @return Response
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
     *
     * @return Response
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
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @Route("/tasks/create", name="task_create")
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request, EntityManagerInterface $em)
    {
        $task = new Task();
        $task->setUser($this->getUser());
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_todo_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Task $task
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Task $task, Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('EDIT', $task);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_todo_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @param Task $task
     * @param EntityManagerInterface $em
     *
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     *
     * @return RedirectResponse
     */
    public function toggleTaskAction(Task $task, EntityManagerInterface $em)
    {
        $task->toggle(!$task->isDone());
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_todo_list');
    }

    /**
     * @param Task $task
     * @param EntityManagerInterface $em
     *
     * @Route("/tasks/{id}/delete", name="task_delete")
     *
     * @return RedirectResponse
     */
    public function deleteTaskAction(Task $task, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('DELETE', $task);

        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_todo_list');
    }
}
