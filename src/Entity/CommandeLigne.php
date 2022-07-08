<?php

namespace App\Entity;

use App\Repository\CommandeLigneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CommandeLigneRepository::class)]
class CommandeLigne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(type: 'integer')]
    private $quantite;
    
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $prix_total;
    
    
    #[ORM\ManyToOne(targetEntity: Produits::class, inversedBy: 'commandeLignes')]
    #[ORM\JoinColumn(nullable: false)]
    private $produits;
    
    #[ORM\ManyToOne(targetEntity: Commandes::class, inversedBy: 'commandeLignes')]
    private $commande;

    #[ORM\Column(type: 'array', nullable: true)]
    private $pointure = [ ];
    
    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixTotal(): ?string
    {
        return $this->prix_total;
    }

    public function setPrixTotal(string $prix_total): self
    {
        $this->prix_total = $prix_total;

        return $this;
    }


    public function getProduits(): ?Produits
    {
        return $this->produits;
    }

    public function setProduits(?Produits $produits): self
    {
        $this->produits = $produits;

        return $this;
    }

    public function getCommande(): ?Commandes
    {
        return $this->commande;
    }

    public function setCommande(?Commandes $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
    public function __toString()
    {
        return $this->id;
    }

    public function getPointure(): ? array
    {
        return $this->pointure;
    }

    public function setPointure(?array $pointure): self
    {
        $this->pointure = $pointure;

        return $this;
    }

}
