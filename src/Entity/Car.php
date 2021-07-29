<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 * @UniqueEntity(fields={"registration"}, message="Cette plaque est déjà utilisée")
 * @Vich\Uploadable
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
     * @ORM\Column(name="registration", type="string", length=10, unique=true)
     * @Assert\Regex(
     *  pattern="/^[a-zA-Z]{2}[. \/\-]?[0-9]{3}[. \/\-]?[a-zA-Z]{2}$/",
     *  message="Plaque d'immatricultation type : 2 chiffres - 3 lettres - 2 chiffres"
     * )
     */
    private $registration;



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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

   /**
     * @Vich\UploadableField(mapping="cars", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

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


    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): self
    {
        $this->registration =preg_replace('/[. \/ \-]/', '', $registration) ;

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

    public function __toString()
    {
        return $this->registration . ' ' . $this->makes  . ' ' . $this->seats . ' places' ;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }
}
