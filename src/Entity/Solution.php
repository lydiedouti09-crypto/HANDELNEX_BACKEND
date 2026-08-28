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

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nomFr = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nomEn = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nomDe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionDe = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionComplete = null;

    // --- NOUVEAU : versions traduites de la description complète ---
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionCompleteFr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionCompleteEn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionCompleteDe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageDe = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $icone = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = 'brouillon'; // brouillon | publie | archive

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lienGooglePlay = null;

    #[ORM\Column]
    private int $ordreAffichage = 0;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getNomFr(): ?string { return $this->nomFr; }
    public function setNomFr(?string $nomFr): static { $this->nomFr = $nomFr; return $this; }
    public function getNomEn(): ?string { return $this->nomEn; }
    public function setNomEn(?string $nomEn): static { $this->nomEn = $nomEn; return $this; }
    public function getNomDe(): ?string { return $this->nomDe; }
    public function setNomDe(?string $nomDe): static { $this->nomDe = $nomDe; return $this; }
    public function getDescriptionFr(): ?string { return $this->descriptionFr; }
    public function setDescriptionFr(?string $descriptionFr): static { $this->descriptionFr = $descriptionFr; return $this; }
    public function getDescriptionEn(): ?string { return $this->descriptionEn; }
    public function setDescriptionEn(?string $descriptionEn): static { $this->descriptionEn = $descriptionEn; return $this; }
    public function getDescriptionDe(): ?string { return $this->descriptionDe; }
    public function setDescriptionDe(?string $descriptionDe): static { $this->descriptionDe = $descriptionDe; return $this; }

    public function getDescriptionComplete(): ?string
    {
        return $this->descriptionComplete;
    }

    public function setDescriptionComplete(?string $descriptionComplete): static
    {
        $this->descriptionComplete = $descriptionComplete;
        return $this;
    }

    // --- NOUVEAU : getters/setters des descriptions complètes traduites ---
    public function getDescriptionCompleteFr(): ?string { return $this->descriptionCompleteFr; }
    public function setDescriptionCompleteFr(?string $v): static { $this->descriptionCompleteFr = $v; return $this; }
    public function getDescriptionCompleteEn(): ?string { return $this->descriptionCompleteEn; }
    public function setDescriptionCompleteEn(?string $v): static { $this->descriptionCompleteEn = $v; return $this; }
    public function getDescriptionCompleteDe(): ?string { return $this->descriptionCompleteDe; }
    public function setDescriptionCompleteDe(?string $v): static { $this->descriptionCompleteDe = $v; return $this; }

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getLienGooglePlay(): ?string
    {
        return $this->lienGooglePlay;
    }

    public function setLienGooglePlay(?string $lienGooglePlay): static
    {
        $this->lienGooglePlay = $lienGooglePlay;
        return $this;
    }

    public function getOrdreAffichage(): int
    {
        return $this->ordreAffichage;
    }

    public function setOrdreAffichage(int $ordreAffichage): static
    {
        $this->ordreAffichage = $ordreAffichage;
        return $this;
    }

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