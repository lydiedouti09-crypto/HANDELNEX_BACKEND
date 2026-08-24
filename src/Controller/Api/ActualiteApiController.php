<?php

namespace App\Controller\Api;

use App\Entity\Actualite;
use App\Repository\ActualiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/actualites')]
class ActualiteApiController extends AbstractController
{
    public function __construct(
        private readonly ActualiteRepository $actualiteRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'api_actualites_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $actualites = $this->actualiteRepository->findBy(
            ['statut' => 'publie'],
            ['datePublication' => 'DESC']
        );

        return $this->json(array_map($this->toArray(...), $actualites));
    }

    #[Route('/{slug}', name: 'api_actualites_show', methods: ['GET'])]
    public function show(string $slug): JsonResponse
    {
        $actualite = $this->actualiteRepository->findOneBy(['slug' => $slug, 'statut' => 'publie']);

        if (!$actualite) {
            return $this->json(['error' => 'Actualité introuvable'], 404);
        }

        return $this->json($this->toArray($actualite, true));
    }

    // ---- Routes admin (protégées par JWT via security.yaml) ----

    #[Route('/admin/all', name: 'api_actualites_admin_list', methods: ['GET'])]
    public function adminList(): JsonResponse
    {
        $actualites = $this->actualiteRepository->findBy([], ['datePublication' => 'DESC']);

        return $this->json(array_map(fn(Actualite $a) => $this->toArray($a, true), $actualites));
    }

    #[Route('/admin', name: 'api_actualites_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $actualite = new Actualite();
        $this->hydrate($actualite, $data);

        $this->entityManager->persist($actualite);
        $this->entityManager->flush();

        return $this->json($this->toArray($actualite, true), 201);
    }

    #[Route('/admin/{id<\d+>}', name: 'api_actualites_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $actualite = $this->actualiteRepository->find($id);
        if (!$actualite) {
            return $this->json(['error' => 'Actualité introuvable'], 404);
        }

        $data = json_decode($request->getContent(), true) ?? [];
        $this->hydrate($actualite, $data);

        $this->entityManager->flush();

        return $this->json($this->toArray($actualite, true));
    }

    #[Route('/admin/{id<\d+>}', name: 'api_actualites_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $actualite = $this->actualiteRepository->find($id);
        if (!$actualite) {
            return $this->json(['error' => 'Actualité introuvable'], 404);
        }

        $this->entityManager->remove($actualite);
        $this->entityManager->flush();

        return $this->json(['success' => true]);
    }

    private function hydrate(Actualite $actualite, array $data): void
    {
        if (isset($data['titre'])) $actualite->setTitre($data['titre']);
        if (isset($data['slug'])) $actualite->setSlug($data['slug']);
        if (isset($data['contenu'])) $actualite->setContenu($data['contenu']);
        if (isset($data['image'])) $actualite->setImage($data['image']);
        if (isset($data['statut'])) $actualite->setStatut($data['statut']);
        if (isset($data['datePublication'])) {
            $actualite->setDatePublication(new \DateTimeImmutable($data['datePublication']));
        }
    }

    private function toArray(Actualite $actualite, bool $detail = false): array
    {
        $data = [
            'id' => $actualite->getId(),
            'titre' => $actualite->getTitre(),
            'slug' => $actualite->getSlug(),
            'image' => $actualite->getImage(),
            'statut' => $actualite->getStatut(),
            'datePublication' => $actualite->getDatePublication()?->format('Y-m-d'),
        ];

        if ($detail) {
            $data['contenu'] = $actualite->getContenu();
        }

        return $data;
    }
}