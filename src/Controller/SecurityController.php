<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/admin/login', name: 'admin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si déjà connecté, inutile de repasser par le login
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_dashboard');
        }

        // Dernière erreur de connexion, s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier email saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/admin/logout', name: 'admin_logout')]
    public function logout(): void
    {
        // Cette méthode ne s'exécute jamais : la déconnexion est interceptée
        // par le firewall Symfony avant d'arriver ici (voir security.yaml).
        throw new \LogicException('Cette méthode ne devrait jamais être appelée directement.');
    }
}