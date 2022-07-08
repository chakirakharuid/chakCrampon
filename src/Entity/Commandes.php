<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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


    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $prix_total;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;


    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeLigne::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $commandeLignes;

    public function __construct()
    {
        $this->commandeLignes = new ArrayCollection();
    }

   

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

    /**
     * @return Collection<int, CommandeLigne>
     */
    public function getCommandeLignes(): Collection
    {
        return $this->commandeLignes;
    }

    public function addCommandeLigne(CommandeLigne $commandeLigne): self
    {
        if (!$this->commandeLignes->contains($commandeLigne)) {
            $this->commandeLignes[] = $commandeLigne;
            $commandeLigne->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeLigne(CommandeLigne $commandeLigne): self
    {
        if ($this->commandeLignes->removeElement($commandeLigne)) {
            // set the owning side to null (unless already changed)
            if ($commandeLigne->getCommande() === $this) {
                $commandeLigne->setCommande(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }
}
