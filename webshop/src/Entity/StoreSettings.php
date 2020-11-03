<?php

namespace App\Entity;

use App\Repository\StoreSettingsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StoreSettingsRepository::class)
 */
class StoreSettings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $storeName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $address;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("\DateTimeInterface")
     */
    private $newProductsDate;

    public function getStoreName(): ?string
    {
        return $this->storeName;
    }

    public function setStoreName(string $storeName): self
    {
        $this->storeName = $storeName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNewProductsDate(): ?\DateTimeInterface
    {
        return $this->newProductsDate;
    }

    public function setNewProductsDate(\DateTimeInterface $newProductsDate): self
    {
        $this->newProductsDate = $newProductsDate;

        return $this;
    }
}
