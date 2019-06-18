<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperationRepository")
 */
class Operation
{
    const OPERATION = [
            0=> 'Libre',
            1=> 'En maintenance',
            2=> 'Chargement/dechargement',
            3=> 'A deplacer',
            4=> 'Parking'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Remorque", inversedBy="operation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $remorque;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parking", inversedBy="operations")
     */
    private $parking;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Quai", inversedBy="operation")
     */
    private $quai;

    public function __construct() {
        $this->date_creation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperation(): ?string
    {
        return $this->operation;
    }

    public function setOperation(string $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getOperationType()
    {
        return self::OPERATION[$this->operation];
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

    public function getRemorque(): ?Remorque
    {
        return $this->remorque;
    }

    public function setRemorque(Remorque $remorque): self
    {
        $this->remorque = $remorque;

        return $this;
    }

    public function getParking(): ?Parking
    {
        return $this->parking;
    }

    public function setParking(?Parking $parking): self
    {
        $this->parking = $parking;

        return $this;
    }

    public function getQuai(): ?Quai
    {
        return $this->quai;
    }

    public function setQuai(?Quai $quai): self
    {
        $this->quai = $quai;

        return $this;
    }
}
