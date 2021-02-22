<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    public const CAN_DELETE = 'delete';

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject)
    {
        if (!$subject instanceof Task) {
            return false;
        }

        if (!in_array($attribute, [self::CAN_DELETE])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param Task $subject
     * @param TokenInterface $token
     * @return bool|void
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        switch ($attribute) {
            case self::CAN_DELETE:
                return $user === $subject->getUser();
                break;
        }
    }
}
