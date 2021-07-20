<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $availability;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $registration;

    /**
     * @ORM\ManyToOne(targetEntity=Rental::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $rentals;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $makes;

    /**
     * @ORM\ManyToOne(targetEntity=Fleet::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fleets;

    /**
     * @ORM\ManyToOne(targetEntity=Seat::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $seats;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $types;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    public function getRentals(): ?Rental
    {
        return $this->rentals;
    }

    public function setRentals(?Rental $rentals): self
    {
        $this->rentals = $rentals;

        return $this;
    }

    public function getMakes(): ?Mark
    {
        return $this->makes;
    }

    public function setMakes(?Mark $makes): self
    {
        $this->makes = $makes;

        return $this;
    }

    public function getFleets(): ?Fleet
    {
        return $this->fleets;
    }

    public function setFleets(?Fleet $fleets): self
    {
        $this->fleets = $fleets;

        return $this;
    }

    public function getSeats(): ?Seat
    {
        return $this->seats;
    }

    public function setSeats(?Seat $seats): self
    {
        $this->seats = $seats;

        return $this;
    }

    public function getTypes(): ?Type
    {
        return $this->types;
    }

    public function setTypes(?Type $types): self
    {
        $this->types = $types;

        return $this;
    }
}
