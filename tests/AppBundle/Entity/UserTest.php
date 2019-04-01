<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

class UserTest extends TestCase
{

    public function testId()
    {
        $user = new User;
        $this->assertEquals(null, $user->getId());
    }

    public function testUsername()
    {
        $user = new User;
        $user->setUsername('Servietsky');
        $this->assertEquals('Servietsky', $user->getUsername());
    }

    public function testPassword()
    {
        $user = new User;
        $user->setPassword('$2y$13$XOH84mnLyji6Y5cJ38A.B.LO.JKR7VluZ5vV4egDSB9Dmxc7uG9CC');
        $this->assertEquals('$2y$13$XOH84mnLyji6Y5cJ38A.B.LO.JKR7VluZ5vV4egDSB9Dmxc7uG9CC', $user->getPassword());
    }

    public function testEmail()
    {
        $user = new User;
        $user->setEmail('rascasse@gmail.com');
        $this->assertEquals('rascasse@gmail.com', $user->getEmail());
    }

    public function testTasks()
    {
        $user = new User;
        $taskStub = $this->createMock(Task::class);
        $user->addTask($taskStub);
        $collection = $user->getTasks();
        $this->assertEquals(false, $collection->isEmpty());
    }

    public function testNoTasks()
    {
        $user = new User;
        $collection = $user->getTasks();
        $this->assertEquals(true, $collection->isEmpty());
    }

    public function testRoles()
    {
        $user = new User;
        $user->setRoles(['ROLE_USER']);
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testNoRoles()
    {
        $user = new User;
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testSalt()
    {
        $user = new User;
        $this->assertEquals(null, $user->getSalt());
    }
}
