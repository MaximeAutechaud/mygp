<?php

namespace App\Controller;

use App\Dto\StoreContactDto;
use App\Entity\Contact;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class StoreContactController extends AbstractController
{
    #[Route('/contact', name: 'store_contact', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        if (!$user) {
            return $this->json([
                'message' => 'User not found',
            ]);
        }
        $file = $request->files->get('file');
        $dto = new StoreContactDTO();
        $dto->subject = $request->get('subject');
        $dto->body = $request->get('body');
        $dto->user_id = $user->getId();
        $dto->file = $file->getClientOriginalName();

        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }
        $contact = new Contact();
        $contact->setSubject($dto->subject);
        $contact->setBody($dto->body);
        $contact->setUser($user);
        $contact->setFile($dto->file);
        $contact->setCreatedAt(new \DateTimeImmutable());

        $em->persist($contact);
        $em->flush();
        $file->move($this->getParameter('upload_dir'), $dto->file);

        return $this->json([
            'message' => 'Contact bien enregistré',
        ]);
    }
}
