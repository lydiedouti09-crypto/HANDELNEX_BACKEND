<?php

namespace App\Controller\Api;

use App\Entity\Solution;
use App\Repository\SolutionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/solutions')]
class SolutionApiController extends AbstractController
{
    public function __construct(
        private readonly SolutionRepository $solutionRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'api_solutions_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $solutions = $this->solutionRepository->findBy(
            ['statut' => 'publie'],
            ['ordreAffichage' => 'ASC']
        );

        return $this->json(array_map($this->toArray(...), $solutions));
    }

    #[Route('/{slug}', name: 'api_solutions_show', methods: ['GET'])]
    public function show(string $slug): JsonResponse
    {
        $solution = $this->solutionRepository->findOneBy(['slug' => $slug, 'statut' => 'publie']);

        if (!$solution) {
            return $this->json(['error' => 'Solution introuvable'], 404);
        }

        return $this->json($this->toArray($solution, true));
    }

    // ---- Routes admin (protégées par JWT via security.yaml) ----

    #[Route('/admin/all', name: 'api_solutions_admin_list', methods: ['GET'])]
    public function adminList(): JsonResponse
    {
        // Renvoie TOUTES les solutions (publiées ou non), pour le dashboard
        $solutions = $this->solutionRepository->findBy([], ['ordreAffichage' => 'ASC']);

        return $this->json(array_map(fn(Solution $s) => $this->toArray($s, true), $solutions));
    }

    #[Route('/admin', name: 'api_solutions_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $solution = new Solution();
        $this->hydrate($solution, $data);

        $this->entityManager->persist($solution);
        $this->entityManager->flush();

        return $this->json($this->toArray($solution, true), 201);
    }

    #[Route('/admin/{id<\d+>}', name: 'api_solutions_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $solution = $this->solutionRepository->find($id);
        if (!$solution) {
            return $this->json(['error' => 'Solution introuvable'], 404);
        }

        $data = json_decode($request->getContent(), true) ?? [];
        $this->hydrate($solution, $data);

        $this->entityManager->flush();

        return $this->json($this->toArray($solution, true));
    }

    #[Route('/admin/{id<\d+>}', name: 'api_solutions_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $solution = $this->solutionRepository->find($id);
        if (!$solution) {
            return $this->json(['error' => 'Solution introuvable'], 404);
        }

        $this->entityManager->remove($solution);
        $this->entityManager->flush();

        return $this->json(['success' => true]);
    }

    private function hydrate(Solution $solution, array $data): void
    {
        if (isset($data['nom'])) $solution->setNom($data['nom']);
        if (isset($data['slug'])) $solution->setSlug($data['slug']);
        if (isset($data['description'])) $solution->setDescription($data['description']);
        if (isset($data['descriptionComplete'])) $solution->setDescriptionComplete($data['descriptionComplete']);
        if (isset($data['image'])) $solution->setImage($data['image']);
        if (isset($data['icone'])) $solution->setIcone($data['icone']);
        if (isset($data['categorie'])) $solution->setCategorie($data['categorie']);
        if (isset($data['lienGooglePlay'])) $solution->setLienGooglePlay($data['lienGooglePlay']);
        if (isset($data['statut'])) $solution->setStatut($data['statut']);
        if (isset($data['ordreAffichage'])) $solution->setOrdreAffichage($data['ordreAffichage']);
    }

    private function toArray(Solution $solution, bool $detail = false): array
    {
        $data = [
            'id' => $solution->getId(),
            'nom' => $solution->getNom(),
            'slug' => $solution->getSlug(),
            'description' => $solution->getDescription(),
            'image' => $solution->getImage(),
            'icone' => $solution->getIcone(),
            'categorie' => $solution->getCategorie(),
            'lienGooglePlay' => $solution->getLienGooglePlay(),
            'statut' => $solution->getStatut(),
            'ordreAffichage' => $solution->getOrdreAffichage(),
        ];

        if ($detail) {
            $data['descriptionComplete'] = $solution->getDescriptionComplete();
        }

        return $data;
    }
}