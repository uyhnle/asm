<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Discount;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="orders")
     */
    private $Customer;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class, inversedBy="orders")
     */
    private $Car;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscount(): ?string
    {
        return $this->Discount;
    }

    public function setDiscount(string $Discount): self
    {
        $this->Discount = $Discount;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomer(?Customer $Customer): self
    {
        $this->Customer = $Customer;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->Car;
    }

    public function setCar(?Car $Car): self
    {
        $this->Car = $Car;

        return $this;
    }
    public function __toString() {
        return (string)$this->getId();
    }
}
