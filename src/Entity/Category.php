<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]

class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
//    permet d'éviter les champs vides pour les libellés
// https://symfony.com/doc/current/reference/constraints/NotBlank.html
    #[Assert\NotBlank(message: "Veuillez indiquer le libelle de votre catégorie")]
    private ?string $libelle = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: NFT::class, orphanRemoval: true)]
    private Collection $nfts;

    public function __construct()
    {
        $this->nfts = new ArrayCollection();
    }

    public function __toString(){
        return $this->libelle;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, NFT>
     */
    public function getNfts(): Collection
    {
        return $this->nfts;
    }

    public function addNft(NFT $nft): static
    {
        if (!$this->nfts->contains($nft)) {
            $this->nfts->add($nft);
            $nft->setCategory($this);
        }

        return $this;
    }

    public function removeNft(NFT $nft): static
    {
        if ($this->nfts->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getCategory() === $this) {
                $nft->setCategory(null);
            }
        }

        return $this;
    }



}
