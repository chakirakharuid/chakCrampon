<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date_commande;

    #[ORM\Column(type: 'string', length: 30)]
    private $statut;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $prix_total;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'commandes')]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: CommandeLigne::class, inversedBy: 'commandes')]
    private $une_ligne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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

    public function getUtilisateur(): ?Utilisateurs
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateurs $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getUneLigne(): ?CommandeLigne
    {
        return $this->une_ligne;
    }

    public function setUneLigne(?CommandeLigne $une_ligne): self
    {
        $this->une_ligne = $une_ligne;

        return $this;
    }
}
