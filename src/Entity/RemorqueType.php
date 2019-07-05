<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RemorqueTypeRepository")
 */
class RemorqueType
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
    private $denomination;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Remorque", mappedBy="type")
     */
    private $remorques;

    public function __construct()
    {
        $this->remorques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * @return Collection|Remorque[]
     */
    public function getRemorques(): Collection
    {
        return $this->remorques;
    }

    public function addRemorque(Remorque $remorque): self
    {
        if (!$this->remorques->contains($remorque)) {
            $this->remorques[] = $remorque;
            $remorque->setType($this);
        }

        return $this;
    }

    public function removeRemorque(Remorque $remorque): self
    {
        if ($this->remorques->contains($remorque)) {
            $this->remorques->removeElement($remorque);
            // set the owning side to null (unless already changed)
            if ($remorque->getType() === $this) {
                $remorque->setType(null);
            }
        }

        return $this;
    }
}
