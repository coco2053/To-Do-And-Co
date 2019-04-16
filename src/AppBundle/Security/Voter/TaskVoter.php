<?php

namespace AppBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TaskVoter.
 */
class TaskVoter extends Voter
{
    /**
     * @param $attribute
     * @param $subject
     *
     * @return boolean
     */
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['DELETE', 'EDIT'])
            && $subject instanceof \AppBundle\Entity\Task;
    }

    /**
     * @param $attribute
     * @param $task
     * @param TokenInterface $token
     *
     * @return boolean
     */
    protected function voteOnAttribute($attribute, $task, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'EDIT':
                if ($user == $task->getUser()) {
                    return true;
                }
                if ($user->isAdmin() && $task->getUser()->isAnon()) {
                    return true;
                }
                break;
            case 'DELETE':
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
