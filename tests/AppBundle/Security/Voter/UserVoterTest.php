<?php

namespace AppBundle\Tests\Security\Voter;

use AppBundle\Entity\User;
use AppBundle\Security\Voter\UserVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserVoterTest extends TestCase
{
    private $voter;
    private $token;
    private $user;

    public function setUp()
    {
        $this->voter = new UserVoter();
        $this->user = $this->createMock(User::class);
        $this->token = new UsernamePasswordToken($this->user, 'credentials', 'memory');
    }

    public function testUserVoterGet()
    {
        $this->user->method('isAdmin')->willReturn(1);
        $this->assertSame(1, $this->voter->vote($this->token, $this->user, ['GET']));
    }

    public function testUserVoterGetNotAdmin()
    {
        $this->user->method('isAdmin')->willReturn(0);
        $this->assertSame(-1, $this->voter->vote($this->token, $this->user, ['GET']));
    }

    public function testUserVoterGetNoUser()
    {
        $token = new AnonymousToken('secret', 'anonymous');
        $this->assertSame(-1, $this->voter->vote($token, $this->user, ['GET']));
    }

    public function testUserVoterEdit()
    {
        $this->user->method('isAdmin')->willReturn(1);
        $this->assertSame(1, $this->voter->vote($this->token, $this->user, ['EDIT']));
    }

    public function testUserVoterEditNotAdmin()
    {
        $this->user->method('isAdmin')->willReturn(0);
        $this->assertSame(-1, $this->voter->vote($this->token, $this->user, ['EDIT']));
    }
}
