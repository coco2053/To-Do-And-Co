<?php
namespace AppBundle\Tests\Form;

use AppBundle\Form\TaskType;
use AppBundle\Entity\Task;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidDataTask()
    {
        $formData = array(
            'title' => 'title',
            'content' => 'content',
        );
        $form = $this->factory->create(TaskType::class);
        $task = new Task();
        $task->setTitle($formData['title']);
        $task->setContent($formData['content']);

        // submit the data to the form directly
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($task->getTitle(), $form->get('title')->getData());
        $this->assertEquals($task->getContent(), $form->get('content')->getData());
        $view = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
