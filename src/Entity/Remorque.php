<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RemorqueRepository")
 */
class Remorque
{

    const REMORQUETYPE = [
            1=> 'Double plancher',
            2=> 'Double plancher hayon',
            3=> 'Bâchée'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    private $remorque;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_edition;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $maintenance = false;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Operation", mappedBy="remorque", cascade={"persist", "remove"})
     */
    private $operation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RemorqueType", inversedBy="remorques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;


    public function __construct() {
        $this->date_creation = new \DateTime();
        $this->date_edition = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRemorque(): ?string
    {
        return $this->remorque;
    }

    public function setRemorque(string $remorque): self
    {
        $this->remorque = $remorque;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->date_edition;
    }

    public function setDateEdition(\DateTimeInterface $date_edition): self
    {
        $this->date_edition = $date_edition;

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

    public function setOperation(Operation $operation): self
    {
        $this->operation = $operation;

        // set the owning side of the relation if necessary
        if ($this !== $operation->getRemorque()) {
            $operation->setRemorque($this);
        }

        return $this;
    }

    public function getType(): ?RemorqueType
    {
        return $this->type;
    }

    public function setType(?RemorqueType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
