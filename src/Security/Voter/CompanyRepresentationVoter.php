<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Core\Company\Model\CompanyRepresentation;
use App\Core\User\Model\Role;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CompanyRepresentationVoter extends Voter
{
    const COMPANY_REPRESENTATION_GET = 'COMPANY_REPRESENTATION_GET';

    public function __construct(
        private readonly Security $security
    )
    {}

    /**
     * @param string $attribute
     * @param CompanyRepresentation $subject
     */
    protected function supports(string $attribute, $subject): bool {
        $supportsAttribute = in_array($attribute, [self::COMPANY_REPRESENTATION_GET], true);

        $supportsSubject = $subject instanceof CompanyRepresentation;
        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param string $attribute
     * @param CompanyRepresentation $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return match($attribute)
        {
            self::COMPANY_REPRESENTATION_GET => $this->security->isGranted(Role::ROLE_ADMIN) || $this->canRead($subject),
            default => false
        };
    }

    /**
     * Checks if user is permitted to perform read entity operation
     * @param CompanyRepresentation $subject
     * @return bool
     */
    private function canRead(CompanyRepresentation $subject): bool
    {
        return $this->security->isGranted(Role::ROLE_REPRESENTATIVE) && $subject->getCompanyUser() === $this->security->getUser();
    }
}

