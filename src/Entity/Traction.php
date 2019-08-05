<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TractionRepository")
 */
class Traction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $affectation;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $porte;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Operation", mappedBy="traction", cascade={"persist", "remove"})
     */
    private $operation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAffectation(): ?string
    {
        return $this->affectation;
    }

    public function setAffectation(string $affectation): self
    {
        $this->affectation = $affectation;

        return $this;
    }

    public function getPorte(): ?string
    {
        return $this->porte;
    }

    public function setPorte(string $porte): self
    {
        $this->porte = $porte;

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
        $newTraction = $operation === null ? null : $this;
        if ($newTraction !== $operation->getTraction()) {
            $operation->setTraction($newTraction);
        }

        return $this;
    }
}
