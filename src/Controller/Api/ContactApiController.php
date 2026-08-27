<?php

namespace App\Controller\Api;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/contact')]
class ContactApiController extends AbstractController
{
    // Ta clé SECRÈTE reCAPTCHA (différente de la clé publique utilisée dans React)
    private const RECAPTCHA_SECRET_KEY = '6LfBVJstAAAAAOXmsrMrWLXaZeVwR8Xa_xf2eO48';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ContactRepository $contactRepository,
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
        $captchaToken = $data['captchaToken'] ?? null;

        // Vérification du CAPTCHA auprès de Google, avant toute autre validation
        if (!$captchaToken || !$this->verifyCaptcha($captchaToken)) {
            return $this->json(['errors' => ['captcha' => 'Vérification CAPTCHA échouée.']], 422);
        }

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

    /**
     * Interroge l'API Google pour vérifier que le token CAPTCHA envoyé par le visiteur est valide.
     */
    private function verifyCaptcha(string $token): bool
    {
        $client = HttpClient::create();

        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => self::RECAPTCHA_SECRET_KEY,
                'response' => $token,
            ],
        ]);

        $result = $response->toArray();

        return $result['success'] ?? false;
    }

    // ---- Admin (protégé par JWT) ----

    #[Route('/admin/all', name: 'api_contact_admin_list', methods: ['GET'])]
    public function adminList(): JsonResponse
    {
        $contacts = $this->contactRepository->findBy([], ['id' => 'DESC']);

        return $this->json(array_map(fn(Contact $c) => [
            'id' => $c->getId(),
            'nom' => $c->getNom(),
            'email' => $c->getEmail(),
            'sujet' => $c->getSujet(),
            'message' => $c->getMessage(),
        ], $contacts));
    }

    #[Route('/admin/{id<\d+>}', name: 'api_contact_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $contact = $this->contactRepository->find($id);
        if (!$contact) {
            return $this->json(['error' => 'Message introuvable'], 404);
        }

        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        return $this->json(['success' => true]);
    }
}