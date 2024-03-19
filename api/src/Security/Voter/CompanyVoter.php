<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Company;
use App\Entity\Role;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CompanyVoter extends Voter
{
    const COMPANY_GET = 'COMPANY_GET';

    public function __construct(
        private readonly Security $security
    )
    {}

    /**
     * @param string $attribute
     * @param User $subject
     */
    protected function supports($attribute, $subject): bool
    {
        $supportsAttribute = in_array(
            $attribute, [
                self::COMPANY_GET
            ],
            true
        );

        $supportsSubject = $subject instanceof Company;
        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param string $attribute
     * @param Company $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return match($attribute)
        {
            self::COMPANY_GET => $this->security->isGranted(Role::ROLE_ADMIN) or $this->canRead($subject),
            default => false
        };
    }

    /**
     * Checks if user is permitted to perform read entity operation
     */
    private function canRead(Company $subject): bool
    {
        if ($this->security->isGranted(Role::ROLE_REPRESENTATIVE)) {
            foreach ($subject->getRepresentatives() as $representative) {
                if ($representative->getCompanyUser() === $this->security->getUser()) {
                    return true;
                }
            }
        }

        return false;
    }
}

