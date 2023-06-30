<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=255)
     */
    private $Car_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Car_brand;

    /**
     * @ORM\Column(type="integer")
     */
    private $Car_price;

    /**
     * @ORM\ManyToOne(targetEntity=Supplier::class, inversedBy="cars")
     */
    private $Supplier;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="Car")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarName(): ?string
    {
        return $this->Car_name;
    }

    public function setCarName(string $Car_name): self
    {
        $this->Car_name = $Car_name;

        return $this;
    }

    public function getCarBrand(): ?string
    {
        return $this->Car_brand;
    }

    public function setCarBrand(string $Car_brand): self
    {
        $this->Car_brand = $Car_brand;

        return $this;
    }

    public function getCarPrice(): ?int
    {
        return $this->Car_price;
    }

    public function setCarPrice(int $Car_price): self
    {
        $this->Car_price = $Car_price;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->Supplier;
    }

    public function setSupplier(?Supplier $Supplier): self
    {
        $this->Supplier = $Supplier;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCar($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCar() === $this) {
                $order->setCar(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return (string)$this->getCarName();
    }
}
