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
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'GET':
                if ($user->isAdmin()) {
                    return true;
                }
                break;
            case 'EDIT':
                if ($user->isAdmin()) {
                    return true;
                }
                break;
        }
        return false;
    }
}
