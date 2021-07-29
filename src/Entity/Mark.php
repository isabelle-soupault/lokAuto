<?php

namespace App\Entity;

use App\Repository\MarkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarkRepository::class)
 */
class Mark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $makes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMakes(): ?string
    {
        return $this->makes;
    }

    public function setMakes(string $makes): self
    {
        $this->makes = $makes;

        return $this;
    }
    public function __toString()
    {
        return $this->makes;
    }
}
