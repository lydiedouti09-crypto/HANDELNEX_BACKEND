<?php

namespace App\Entity;

use App\Repository\SolutionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolutionRepository::class)]
#[ORM\Table(name: 'solution')]
class Solution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 150, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    // =========================
    // NOMS
    // =========================

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nomFr = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nomEn = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nomDe = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nomPtBr = null;

    // =========================
    // DESCRIPTIONS COURTES
    // =========================

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionDe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionPtBr = null;

    // =========================
    // DESCRIPTIONS COMPLETES
    // =========================

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionComplete = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionCompleteFr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionCompleteEn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionCompleteDe = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionCompletePtBr = null;

    // =========================
    // IMAGES
    // =========================

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageDe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePtBr = null;

    // =========================
    // AUTRES
    // =========================

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $icone = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = 'brouillon';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lienGooglePlay = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lienAppleStore = null;

    #[ORM\Column]
    private int $ordreAffichage = 0;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    // =========================
    // ID
    // =========================

    public function getId(): ?int
    {
        return $this->id;
    }

    // =========================
    // NOM
    // =========================

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    // =========================
    // NOMS TRADUITS
    // =========================

    public function getNomFr(): ?string
    {
        return $this->nomFr;
    }

    public function setNomFr(?string $nomFr): static
    {
        $this->nomFr = $nomFr;
        return $this;
    }

    public function getNomEn(): ?string
    {
        return $this->nomEn;
    }

    public function setNomEn(?string $nomEn): static
    {
        $this->nomEn = $nomEn;
        return $this;
    }

    public function getNomDe(): ?string
    {
        return $this->nomDe;
    }

    public function setNomDe(?string $nomDe): static
    {
        $this->nomDe = $nomDe;
        return $this;
    }

    public function getNomPtBr(): ?string
    {
        return $this->nomPtBr;
    }

    public function setNomPtBr(?string $nomPtBr): static
    {
        $this->nomPtBr = $nomPtBr;
        return $this;
    }

    // =========================
    // DESCRIPTIONS
    // =========================

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDescriptionFr(): ?string
    {
        return $this->descriptionFr;
    }

    public function setDescriptionFr(?string $value): static
    {
        $this->descriptionFr = $value;
        return $this;
    }

    public function getDescriptionEn(): ?string
    {
        return $this->descriptionEn;
    }

    public function setDescriptionEn(?string $value): static
    {
        $this->descriptionEn = $value;
        return $this;
    }

    public function getDescriptionDe(): ?string
    {
        return $this->descriptionDe;
    }

    public function setDescriptionDe(?string $value): static
    {
        $this->descriptionDe = $value;
        return $this;
    }

    public function getDescriptionPtBr(): ?string
    {
        return $this->descriptionPtBr;
    }

    public function setDescriptionPtBr(?string $value): static
    {
        $this->descriptionPtBr = $value;
        return $this;
    }

    // =========================
    // DESCRIPTION COMPLETE
    // =========================

    public function getDescriptionComplete(): ?string
    {
        return $this->descriptionComplete;
    }

    public function setDescriptionComplete(?string $value): static
    {
        $this->descriptionComplete = $value;
        return $this;
    }

    public function getDescriptionCompleteFr(): ?string
    {
        return $this->descriptionCompleteFr;
    }

    public function setDescriptionCompleteFr(?string $value): static
    {
        $this->descriptionCompleteFr = $value;
        return $this;
    }

    public function getDescriptionCompleteEn(): ?string
    {
        return $this->descriptionCompleteEn;
    }

    public function setDescriptionCompleteEn(?string $value): static
    {
        $this->descriptionCompleteEn = $value;
        return $this;
    }

    public function getDescriptionCompleteDe(): ?string
    {
        return $this->descriptionCompleteDe;
    }

    public function setDescriptionCompleteDe(?string $value): static
    {
        $this->descriptionCompleteDe = $value;
        return $this;
    }

    public function getDescriptionCompletePtBr(): ?string
    {
        return $this->descriptionCompletePtBr;
    }

    public function setDescriptionCompletePtBr(?string $value): static
    {
        $this->descriptionCompletePtBr = $value;
        return $this;
    }

    // =========================
    // IMAGES
    // =========================

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getImageFr(): ?string
    {
        return $this->imageFr;
    }

    public function setImageFr(?string $imageFr): static
    {
        $this->imageFr = $imageFr;
        return $this;
    }

    public function getImageEn(): ?string
    {
        return $this->imageEn;
    }

    public function setImageEn(?string $imageEn): static
    {
        $this->imageEn = $imageEn;
        return $this;
    }

    public function getImageDe(): ?string
    {
        return $this->imageDe;
    }

    public function setImageDe(?string $imageDe): static
    {
        $this->imageDe = $imageDe;
        return $this;
    }

    public function getImagePtBr(): ?string
    {
        return $this->imagePtBr;
    }

    public function setImagePtBr(?string $imagePtBr): static
    {
        $this->imagePtBr = $imagePtBr;
        return $this;
    }

    // =========================
    // ICONE / CATEGORIE
    // =========================

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(?string $icone): static
    {
        $this->icone = $icone;
        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }

    // =========================
    // STATUT
    // =========================

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    // =========================
    // GOOGLE PLAY
    // =========================

    public function getLienGooglePlay(): ?string
    {
        return $this->lienGooglePlay;
    }

    public function setLienGooglePlay(?string $lienGooglePlay): static
    {
        $this->lienGooglePlay = $lienGooglePlay;
        return $this;
    }

    // =========================
    // APPLE STORE
    // =========================

    public function getLienAppleStore(): ?string
    {
        return $this->lienAppleStore;
    }

    public function setLienAppleStore(?string $lienAppleStore): static
    {
        $this->lienAppleStore = $lienAppleStore;
        return $this;
    }

    // =========================
    // ORDRE
    // =========================

    public function getOrdreAffichage(): int
    {
        return $this->ordreAffichage;
    }

    public function setOrdreAffichage(int $ordreAffichage): static
    {
        $this->ordreAffichage = $ordreAffichage;
        return $this;
    }

    // =========================
    // DATE
    // =========================

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}