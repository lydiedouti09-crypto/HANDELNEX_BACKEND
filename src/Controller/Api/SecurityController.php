<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/login', name: 'api_login_check', methods: ['POST'])]
    public function login(): void
    {
        // Cette méthode ne s'exécute jamais : le firewall "login" (json_login)
        // intercepte la requête avant qu'elle n'arrive ici.
        throw new \LogicException('Ce point ne doit jamais être atteint.');
    }
}