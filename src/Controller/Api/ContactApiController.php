<?php

namespace App\Controller\Api;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[Route('/api/contact')]
class ContactApiController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'api_contact_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $nom = trim($data['nom'] ?? '');
        $email = trim($data['email'] ?? '');
        $sujet = trim($data['sujet'] ?? '');
        $message = trim($data['message'] ?? '');

        // Validation simple des champs obligatoires
        $errors = [];
        if ($nom === '') $errors['nom'] = 'Le nom est requis.';
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'E-mail invalide.';
        if ($sujet === '') $errors['sujet'] = 'Le sujet est requis.';
        if ($message === '') $errors['message'] = 'Le message est requis.';

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], 422);
        }

        $contact = new Contact();
        $contact->setNom($nom);
        $contact->setEmail($email);
        $contact->setSujet($sujet);
        $contact->setMessage($message);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $this->json(['success' => true, 'message' => 'Votre message a bien été envoyé.'], 201);
    }
}