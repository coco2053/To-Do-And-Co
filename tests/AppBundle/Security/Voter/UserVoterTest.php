<?php

namespace AppBundle\Tests\Security\Voter;

use AppBundle\Entity\User;
use AppBundle\Security\Voter\UserVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserVoterTest extends TestCase
{
    /**
     * @dataProvider voterProvider
     *
     */
    public function testUserVoter($user, $expected)
    {
        $voter = new UserVoter();

        $token = new AnonymousToken('secret', 'anonymous');

        if ($user) {
            $token = new UsernamePasswordToken($user, 'credentials', 'memory');
        }

        $this->assertSame($expected, $voter->vote($token, $user, ['GET']));
    }

    public function voterProvider()
    {
        $userOne = $this->createMock(User::class);
        $userOne->method('getId')->willReturn(1);
        $userOne->method('isAdmin')->willReturn(true);
        $userTwo = $this->createMock(User::class);
        $userTwo->method('getId')->willReturn(1);
        $userTwo->method('isAdmin')->willReturn(false);
        return [
            [$userOne, 1],
            [$userTwo, -1]
        ];
    }
}
