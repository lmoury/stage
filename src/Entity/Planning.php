<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
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
