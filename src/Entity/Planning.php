<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
 * @UniqueEntity("tournee", message="Tournée déjà pris")
 */
class Planning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $tournee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chauffeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tracteur;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $bloquer = false;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Operation", mappedBy="planning", cascade={"persist", "remove"})
     */
    private $operation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTournee(): ?int
    {
        return $this->tournee;
    }

    public function setTournee(int $tournee): self
    {
        $this->tournee = $tournee;

        return $this;
    }

    public function getChauffeur(): ?string
    {
        return $this->chauffeur;
    }

    public function setChauffeur(string $chauffeur): self
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }

    public function getTracteur(): ?string
    {
        return $this->tracteur;
    }

    public function setTracteur(string $tracteur): self
    {
        $this->tracteur = $tracteur;

        return $this;
    }

    public function getBloquer(): ?bool
    {
        return $this->bloquer;
    }

    public function setBloquer(bool $bloquer): self
    {
        $this->bloquer = $bloquer;

        return $this;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

        // set (or unset) the owning side of the relation if necessary
        $newPlanning = $operation === null ? null : $this;
        if ($newPlanning !== $operation->getPlanning()) {
            $operation->setPlanning($newPlanning);
        }

        return $this;
    }
}
