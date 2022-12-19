<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanningRepository::class)
 */
class Planning
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_jours;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_crenau;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_journee;

    /**
     * @ORM\ManyToOne(targetEntity=Activity::class, inversedBy="plannings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nom_activite;

    /**
     * @ORM\OneToMany(targetEntity=Creneau::class, mappedBy="planning", orphanRemoval=true)
     */
    private $creneaux;

    public function __construct()
    {
        $this->creneaus = new ArrayCollection();
        $this->creneaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getNbJours(): ?int
    {
        return $this->nb_jours;
    }

    public function setNbJours(int $nb_jours): self
    {
        $this->nb_jours = $nb_jours;

        return $this;
    }

    public function getDureeCrenau(): ?int
    {
        return $this->duree_crenau;
    }

    public function setDureeCrenau(int $duree_crenau): self
    {
        $this->duree_crenau = $duree_crenau;

        return $this;
    }

    public function getDureeJournee(): ?int
    {
        return $this->duree_journee;
    }

    public function setDureeJournee(int $duree_journee): self
    {
        $this->duree_journee = $duree_journee;

        return $this;
    }


    public function getNomActivite(): ?Activity
    {
        return $this->nom_activite;
    }

    public function setNomActivite(?Activity $nom_activite): self
    {
        $this->nom_activite = $nom_activite;

        return $this;
    }

    /**
     * @return Collection<int, Creneau>
     */
    public function getCreneaux(): Collection
    {
        return $this->creneaux;
    }

    public function addCreneaux(Creneau $creneaux): self
    {
        if (!$this->creneaux->contains($creneaux)) {
            $this->creneaux[] = $creneaux;
            $creneaux->setPlanning($this);
        }

        return $this;
    }

    public function removeCreneaux(Creneau $creneaux): self
    {
        if ($this->creneaux->removeElement($creneaux)) {
            // set the owning side to null (unless already changed)
            if ($creneaux->getPlanning() === $this) {
                $creneaux->setPlanning(null);
            }
        }

        return $this;
    }
}
