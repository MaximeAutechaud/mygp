<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JWTSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private LoggerInterface $logger
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            // Déclenché quand un token est généré avec succès (login réussi)
            AuthenticationSuccessEvent::class => 'onAuthenticationSuccess',

            // Déclenché juste avant la création du token JWT
            JWTCreatedEvent::class => 'onJWTCreated',
        ];
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $this->logger->info('✅ JWTSubscriber déclenché !');
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        // Met à jour la date de dernière connexion
        $user->setLastConnection(new \DateTimeImmutable());
        $this->em->persist($user);
        $this->em->flush();
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        // Log pour vérifier
        $this->logger->info('🔥 JWTCreated déclenché pour '.$user->getEmail());

        $user->setLastConnection(new \DateTimeImmutable());
        $this->em->flush();
    }
}
