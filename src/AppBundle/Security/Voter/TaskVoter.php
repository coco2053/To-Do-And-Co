<?php

namespace AppBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['DELETE', 'EDIT'])
            && $subject instanceof \AppBundle\Entity\Task;
    }

    protected function voteOnAttribute($attribute, $task, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'EDIT':
                $role = $user->getRoles();
                if ($user == $task->getUser()) {
                    return true;
                }
                if ($user->isAdmin() && $task->getUser()->isAnon()) {
                    return true;
                }
                break;
            case 'DELETE':
                $role = $user->getRoles();
                if ($user == $task->getUser()) {
                    return true;
                }
                if ($user->isAdmin() && $task->getUser()->isAnon()) {
                    return true;
                }
                break;
        }
        return false;
    }
}
