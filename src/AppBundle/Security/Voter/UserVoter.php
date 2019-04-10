<?php

namespace AppBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserVoter.
 */
class UserVoter extends Voter
{
    /**
     * @param $attribute
     * @param $subject
     *
     * @return boolean
     */
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['GET', 'EDIT'])
            && $subject instanceof \AppBundle\Entity\User;
    }

    /**
     * @param $attribute
     * @param $user
     * @param TokenInterface $token
     *
     * @return boolean
     */
    protected function voteOnAttribute($attribute, $user, TokenInterface $token)
    {
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'GET':
                return $user->isAdmin();
                break;
            case 'EDIT':
                return $user->isAdmin();
                break;
        }
        return false;
    }
}
