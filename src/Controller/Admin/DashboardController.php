<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use App\Entity\Admin;
use App\Entity\Contact;
use App\Entity\Solution;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin_dashboard')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function index(): Response
    {
        $stats = [
            'solutions' => $this->entityManager->getRepository(Solution::class)->count([]),
            'actualites' => $this->entityManager->getRepository(Actualite::class)->count([]),
            'messages' => $this->entityManager->getRepository(Contact::class)->count([]),
            'messagesNonTraites' => $this->entityManager->getRepository(Contact::class)->count(['traite' => false]),
        ];

        return $this->render('admin/dashboard.html.twig', [
            'stats' => $stats,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('HANDELNEX Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::section('Contenu du site');
        yield MenuItem::linkTo(SolutionCrudController::class, 'Solutions', 'fa fa-cubes')->setAction(Action::INDEX);
        yield MenuItem::linkTo(ActualiteCrudController::class, 'Actualités', 'fa fa-newspaper')->setAction(Action::INDEX);
        yield MenuItem::section('Messages');
        yield MenuItem::linkTo(ContactCrudController::class, 'Messages de contact', 'fa fa-envelope')->setAction(Action::INDEX);
        yield MenuItem::section('Administration');
        yield MenuItem::linkTo(AdminCrudController::class, 'Administrateurs', 'fa fa-user-shield')->setAction(Action::INDEX);
        yield MenuItem::section();
        yield MenuItem::linkToUrl('Voir le site', 'fa fa-external-link-alt', '/');
    }
}