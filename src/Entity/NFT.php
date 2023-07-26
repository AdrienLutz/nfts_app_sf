<?php

namespace App\Entity;

use App\Repository\NFTRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NFTRepository::class)]
class NFT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Veuillez saisir la quantité dispo")]
    #[Assert\Type(
        type: 'float',
        message:'La valeur {{value}} n\'est pas un float {{type}}.',
    )]
    private ?float $valeur = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Veuillez saisir la quantité dispo")]
    #[Assert\Type(
        type: 'integer',
        message:'La quantité {{value}} n\'est pas un {{type}}.',
    )]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'nFTs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $useradd = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez saisir le nom")]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUseradd(): ?User
    {
        return $this->useradd;
    }

    public function setUseradd(?User $useradd): static
    {
        $this->useradd = $useradd;

        return $this;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
