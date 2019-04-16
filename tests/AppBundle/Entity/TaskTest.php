<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private $task;

    public function setUp()
    {
        $this->task = new Task();
    }

    public function testId()
    {
        $this->assertEquals(null, $this->task->getId());
    }

    public function testgetCreatedAt()
    {
        $this->task->setCreatedAt(new \DateTime);
        $this->assertEquals(date('Y-m-d H:i:s'), $this->task->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    public function testTitle()
    {
        $this->task->setTitle('La dépression post natale chez les cervidés');
        $this->assertEquals('La dépression post natale chez les cervidés', $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent('Super contenu');
        $this->assertEquals('Super contenu', $this->task->getContent());
    }

    public function testIsDone()
    {
        $this->assertEquals(false, $this->task->IsDone());
    }

    public function testToggle()
    {
        $this->assertEquals(false, $this->task->toggle(false));
    }

    public function testUser()
    {
        $userStub = $this->createMock(User::class);
        $this->task->setUser($userStub);
        $this->assertEquals($userStub, $this->task->getUser());
    }

    public function testNoUser()
    {
        $this->assertEquals('Anonyme', $this->task->getUser()->getUsername());
    }
}
