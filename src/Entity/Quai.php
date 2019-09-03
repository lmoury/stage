<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuaiRepository")
 */
class Quai
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
    private $numero;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $maintenance = false;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Operation", mappedBy="quai", cascade={"persist", "remove"})
     */
    private $operation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Traction", mappedBy="quai")
     */
    private $tractions;

    public function __construct()
    {
        $this->tractions = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getMaintenance(): ?bool
    {
        return $this->maintenance;
    }

    public function setMaintenance(bool $maintenance): self
    {
        $this->maintenance = $maintenance;

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
        $newQuai = $operation === null ? null : $this;
        if ($newQuai !== $operation->getQuai()) {
            $operation->setQuai($newQuai);
        }

        return $this;
    }

    /**
     * @return Collection|Traction[]
     */
    public function getTractions(): Collection
    {
        return $this->tractions;
    }

    public function addTraction(Traction $traction): self
    {
        if (!$this->tractions->contains($traction)) {
            $this->tractions[] = $traction;
            $traction->setQuai($this);
        }

        return $this;
    }

    public function removeTraction(Traction $traction): self
    {
        if ($this->tractions->contains($traction)) {
            $this->tractions->removeElement($traction);
            // set the owning side to null (unless already changed)
            if ($traction->getQuai() === $this) {
                $traction->setQuai(null);
            }
        }

        return $this;
    }

}
