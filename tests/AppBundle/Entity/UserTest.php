<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testId()
    {
        $this->assertEquals(null, $this->user->getId());
    }

    public function testUsername()
    {
        $this->user->setUsername('Servietsky');
        $this->assertEquals('Servietsky', $this->user->getUsername());
    }

    public function testPassword()
    {
        $this->user->setPassword('$2y$13$XOH84mnLyji6Y5cJ38A.B.LO.JKR7VluZ5vV4egDSB9Dmxc7uG9CC');
        $this->assertEquals('$2y$13$XOH84mnLyji6Y5cJ38A.B.LO.JKR7VluZ5vV4egDSB9Dmxc7uG9CC', $this->user->getPassword());
    }

    public function testEmail()
    {
        $this->user->setEmail('rascasse@gmail.com');
        $this->assertEquals('rascasse@gmail.com', $this->user->getEmail());
    }

    public function testTasks()
    {
        $taskStub = $this->createMock(Task::class);
        $this->user->addTask($taskStub);
        $collection = $this->user->getTasks();
        $this->assertEquals(false, $collection->isEmpty());
        $this->user->removeTask($taskStub);
        $this->assertEquals(true, $collection->isEmpty());
    }

    public function testNoTasks()
    {
        $collection = $this->user->getTasks();
        $this->assertEquals(true, $collection->isEmpty());
    }

    public function testIsAdmin()
    {
        $this->assertEquals(false, $this->user->IsAdmin());
    }

    public function testIsAnon()
    {
        $this->assertEquals(false, $this->user->IsAnon());
        $this->user->setUsername('Anonyme');
        $this->assertEquals(true, $this->user->IsAnon());
    }

    public function testRoles()
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertEquals(['ROLE_USER'], $this->user->getRoles());
    }

    public function testNoRoles()
    {
        $this->assertEquals(['ROLE_USER'], $this->user->getRoles());
    }

    public function testSalt()
    {
        $this->assertEquals(null, $this->user->getSalt());
    }

    public function testEraseCredential()
    {
        static::assertSame(null, $this->user->eraseCredentials());
    }
}
