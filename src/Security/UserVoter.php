<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $data)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$data instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $data, TokenInterface $token)
    {
        $userLogin = $token->getUser();

        if (!$userLogin instanceof User) {
            return false;
        }

        /** @var User $userProfile */
        $userProfile = $data;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($userProfile, $userLogin);
            case self::EDIT:
                return $this->canEdit($userProfile, $userLogin);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(User $userProfile, $userLogin)
    {
        if ($this->canEdit($userProfile, $userLogin)) {
            return true;
        }
    }

    private function canEdit(User $userProfile, $userLogin)
    {
        return  $userProfile->getId() === $userLogin->getId();
    }
}
