<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{

    public function testId()
    {
        $task = new Task;
        $this->assertEquals(null, $task->getId());
    }

    public function testCreatedAt()
    {
        $task = new Task;
        $this->assertEquals(date('Y-m-d H:i:s'), $task->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    public function testTitle()
    {
        $task = new Task;
        $task->setTitle('La dépression post natale chez les cervidés');
        $this->assertEquals('La dépression post natale chez les cervidés', $task->getTitle());
    }

    public function testContent()
    {
        $task = new Task;
        $task->setContent('Super contenu');
        $this->assertEquals('Super contenu', $task->getContent());
    }

    public function testIsDone()
    {
        $task = new Task;
        $this->assertEquals(false, $task->IsDone());
    }

    public function testToggle()
    {
        $task = new Task;
        $this->assertEquals(false, $task->toggle(false));
    }

    public function testUser()
    {
        $task = new Task;
        $userStub = $this->createMock(User::class);
        $task->setUser($userStub);
        $this->assertEquals($userStub, $task->getUser());
    }

    public function testNoUser()
    {
        $task = new Task;
        $this->assertEquals('Anonyme', $task->getUser()->getUsername());
    }
}
