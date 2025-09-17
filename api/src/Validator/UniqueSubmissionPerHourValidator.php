<?php
namespace App\Validator;

use App\Entity\Contact;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueSubmissionPerHourValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Security $security
    ) {}

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueSubmissionPerHour) {
            return;
        }

        /** @var User|null $user */
        $user = $this->security->getUser();
        if (!$user) {
            return;
        }

        $lastCreation = $this->em->getRepository(Contact::class)->findOneBy(
            ['user' => $user],
            ['created_at' => 'DESC']
        );

        if ($lastCreation && $lastCreation->getCreatedAt() > new \DateTimeImmutable('-1 hour')) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
