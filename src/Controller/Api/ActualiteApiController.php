<?php

namespace App\Controller\Api;

use App\Entity\Actualite;
use App\Repository\ActualiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/api/actualites')]
class ActualiteApiController extends AbstractController
{
    public function __construct(
        private readonly ActualiteRepository $actualiteRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    // =========================
    // PUBLIC - LISTE
    // =========================

    #[Route('', name: 'api_actualites_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $actualites = $this->actualiteRepository->findBy(
            ['statut' => 'publie'],
            ['datePublication' => 'DESC']
        );

        return $this->json(
            array_map($this->toArray(...), $actualites)
        );
    }

    // =========================
    // PUBLIC - DETAIL
    // =========================

    #[Route('/{slug}', name: 'api_actualites_show', methods: ['GET'])]
    public function show(string $slug): JsonResponse
    {
        $actualite = $this->actualiteRepository->findOneBy([
            'slug' => $slug,
            'statut' => 'publie'
        ]);

        if (!$actualite) {
            return $this->json([
                'error' => 'Actualité introuvable'
            ], 404);
        }

        return $this->json(
            $this->toArray($actualite, true)
        );
    }

    // =========================
    // ADMIN - LISTE
    // =========================

    #[Route('/admin/all', name: 'api_actualites_admin_list', methods: ['GET'])]
    public function adminList(): JsonResponse
    {
        $actualites = $this->actualiteRepository->findBy(
            [],
            ['datePublication' => 'DESC']
        );

        return $this->json(
            array_map(
                fn(Actualite $a) => $this->toArray($a, true),
                $actualites
            )
        );
    }

    // =========================
    // ADMIN - UPLOAD IMAGE
    // =========================

    #[Route('/admin/image-upload', name: 'api_actualites_image_upload', methods: ['POST'])]
    public function uploadImage(Request $request): JsonResponse
    {
        $image = $request->files->get('image');

        if (!$image instanceof UploadedFile || !$image->isValid()) {
            return $this->json([
                'error' => 'Image invalide'
            ], 400);
        }

        if (!in_array(
            $image->getMimeType(),
            [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif'
            ],
            true
        )) {
            return $this->json([
                'error' => 'Format d\'image non autorisé'
            ], 400);
        }

        if ($image->getSize() > 10 * 1024 * 1024) {
            return $this->json([
                'error' => 'L\'image ne doit pas dépasser 10 Mo'
            ], 400);
        }

        $uploadDirectory = dirname(__DIR__, 3)
            . '/public/uploads/actualites';

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0775, true);
        }

        $filename = uniqid('actualite_', true)
            . '.'
            . $image->guessExtension();

        $image->move(
            $uploadDirectory,
            $filename
        );

        return $this->json([
            'url' => '/uploads/actualites/' . $filename
        ]);
    }

    // =========================
    // ADMIN - CREATION
    // =========================

    #[Route('/admin', name: 'api_actualites_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode(
            $request->getContent(),
            true
        ) ?? [];

        $actualite = new Actualite();

        $this->hydrate(
            $actualite,
            $data
        );

        if (!$actualite->getSlug()) {
            $actualite->setSlug(
                $this->uniqueSlug(
                    $actualite->getTitre() ?? 'actualite'
                )
            );
        }

        $this->entityManager->persist($actualite);
        $this->entityManager->flush();

        return $this->json(
            $this->toArray($actualite, true),
            201
        );
    }

    // =========================
    // ADMIN - MODIFICATION
    // =========================

    #[Route('/admin/{id<\d+>}', name: 'api_actualites_update', methods: ['PUT'])]
    public function update(
        int $id,
        Request $request
    ): JsonResponse {

        $actualite = $this->actualiteRepository->find($id);

        if (!$actualite) {
            return $this->json([
                'error' => 'Actualité introuvable'
            ], 404);
        }

        $data = json_decode(
            $request->getContent(),
            true
        ) ?? [];

        $this->hydrate(
            $actualite,
            $data
        );

        $this->entityManager->flush();

        return $this->json(
            $this->toArray($actualite, true)
        );
    }

    // =========================
    // ADMIN - SUPPRESSION
    // =========================

    #[Route('/admin/{id<\d+>}', name: 'api_actualites_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $actualite = $this->actualiteRepository->find($id);

        if (!$actualite) {
            return $this->json([
                'error' => 'Actualité introuvable'
            ], 404);
        }

        $this->entityManager->remove($actualite);
        $this->entityManager->flush();

        return $this->json([
            'success' => true
        ]);
    }

    // =========================
    // HYDRATE
    // =========================

    private function hydrate(
        Actualite $actualite,
        array $data
    ): void {

        if (isset($data['titre'])) {
            $actualite->setTitre($data['titre']);
        }

        if (isset($data['slug'])) {
            $actualite->setSlug($data['slug']);
        }

        if (isset($data['contenu'])) {
            $actualite->setContenu($data['contenu']);
        }

        // FR
        if (isset($data['titreFr'])) {
            $actualite->setTitreFr($data['titreFr']);
        }

        if (isset($data['contenuFr'])) {
            $actualite->setContenuFr($data['contenuFr']);
        }

        // EN
        if (isset($data['titreEn'])) {
            $actualite->setTitreEn($data['titreEn']);
        }

        if (isset($data['contenuEn'])) {
            $actualite->setContenuEn($data['contenuEn']);
        }

        // DE
        if (isset($data['titreDe'])) {
            $actualite->setTitreDe($data['titreDe']);
        }

        if (isset($data['contenuDe'])) {
            $actualite->setContenuDe($data['contenuDe']);
        }

        // PT-BR
        if (isset($data['titrePtBr'])) {
            $actualite->setTitrePtBr($data['titrePtBr']);
        }

        if (isset($data['contenuPtBr'])) {
            $actualite->setContenuPtBr($data['contenuPtBr']);
        }

        // Fallback titre principal
        if (
            !$actualite->getTitre()
            && $actualite->getTitreFr()
        ) {
            $actualite->setTitre(
                $actualite->getTitreFr()
            );
        }

        // Fallback contenu principal
        if (
            !$actualite->getContenu()
            && $actualite->getContenuFr()
        ) {
            $actualite->setContenu(
                $actualite->getContenuFr()
            );
        }

        // =========================
        // IMAGES
        // =========================

        if (isset($data['image'])) {
            $actualite->setImage($data['image']);
        }

        if (isset($data['imageFr'])) {
            $actualite->setImageFr($data['imageFr']);
        }

        if (isset($data['imageEn'])) {
            $actualite->setImageEn($data['imageEn']);
        }

        if (isset($data['imageDe'])) {
            $actualite->setImageDe($data['imageDe']);
        }

        if (isset($data['imagePtBr'])) {
            $actualite->setImagePtBr($data['imagePtBr']);
        }

        // =========================
        // AUTRES
        // =========================

        if (isset($data['statut'])) {
            $actualite->setStatut($data['statut']);
        }

        if (isset($data['datePublication'])) {
            $actualite->setDatePublication(
                new \DateTimeImmutable(
                    $data['datePublication']
                )
            );
        }
    }

    // =========================
    // TO ARRAY
    // =========================

    private function toArray(
        Actualite $actualite,
        bool $detail = false
    ): array {

        $data = [
            'id' => $actualite->getId(),

            'titre' => $actualite->getTitre(),
            'slug' => $actualite->getSlug(),

            // FR
            'titreFr' => $actualite->getTitreFr(),
            'contenuFr' => $actualite->getContenuFr(),

            // EN
            'titreEn' => $actualite->getTitreEn(),
            'contenuEn' => $actualite->getContenuEn(),

            // DE
            'titreDe' => $actualite->getTitreDe(),
            'contenuDe' => $actualite->getContenuDe(),

            // PT-BR
            'titrePtBr' => $actualite->getTitrePtBr(),
            'contenuPtBr' => $actualite->getContenuPtBr(),

            // Images
            'image' => $actualite->getImage(),
            'imageFr' => $actualite->getImageFr(),
            'imageEn' => $actualite->getImageEn(),
            'imageDe' => $actualite->getImageDe(),
            'imagePtBr' => $actualite->getImagePtBr(),

            'statut' => $actualite->getStatut(),

            'datePublication' =>
                $actualite->getDatePublication()?->format('Y-m-d'),
        ];

        if ($detail) {
            $data['contenu'] =
                $actualite->getContenu();
        }

        return $data;
    }

    // =========================
    // SLUG UNIQUE
    // =========================

    private function uniqueSlug(string $value): string
    {
        $base = (new AsciiSlugger())
            ->slug($value)
            ->lower()
            ->toString()
            ?: 'actualite';

        $slug = $base;
        $suffix = 2;

        while (
            $this->actualiteRepository
                ->findOneBy(['slug' => $slug])
        ) {
            $slug = $base . '-' . $suffix++;
        }

        return $slug;
    }
}