<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
#[ORM\Table(name: 'actualite')]
class Actualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $titre = null;

    #[ORM\Column(length: 150, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $titreFr = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $titreEn = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $titreDe = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenuFr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenuEn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenuDe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageDe = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $datePublication = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = 'brouillon'; // brouillon | publie

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->datePublication = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;
        return $this;
    }

    public function getTitreFr(): ?string { return $this->titreFr; }
    public function setTitreFr(?string $titreFr): static { $this->titreFr = $titreFr; return $this; }
    public function getTitreEn(): ?string { return $this->titreEn; }
    public function setTitreEn(?string $titreEn): static { $this->titreEn = $titreEn; return $this; }
    public function getTitreDe(): ?string { return $this->titreDe; }
    public function setTitreDe(?string $titreDe): static { $this->titreDe = $titreDe; return $this; }
    public function getContenuFr(): ?string { return $this->contenuFr; }
    public function setContenuFr(?string $contenuFr): static { $this->contenuFr = $contenuFr; return $this; }
    public function getContenuEn(): ?string { return $this->contenuEn; }
    public function setContenuEn(?string $contenuEn): static { $this->contenuEn = $contenuEn; return $this; }
    public function getContenuDe(): ?string { return $this->contenuDe; }
    public function setContenuDe(?string $contenuDe): static { $this->contenuDe = $contenuDe; return $this; }

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

    public function getDatePublication(): ?\DateTimeImmutable
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeImmutable $datePublication): static
    {
        $this->datePublication = $datePublication;
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