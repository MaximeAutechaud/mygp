<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use App\Entity\User;

class JWTLoginListener
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        // Mettre à jour la date de dernière connexion
        $user->setLastConnection(new \DateTimeImmutable());

        $this->em->persist($user);
        $this->em->flush();
    }
}
