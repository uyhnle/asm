<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
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
    private $Customer_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Customer_mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Customer_phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Customer_address;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="Customer")
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

    public function getCustomerName(): ?string
    {
        return $this->Customer_name;
    }

    public function setCustomerName(string $Customer_name): self
    {
        $this->Customer_name = $Customer_name;

        return $this;
    }

    public function getCustomerMail(): ?string
    {
        return $this->Customer_mail;
    }

    public function setCustomerMail(string $Customer_mail): self
    {
        $this->Customer_mail = $Customer_mail;

        return $this;
    }

    public function getCustomerPhone(): ?string
    {
        return $this->Customer_phone;
    }

    public function setCustomerPhone(string $Customer_phone): self
    {
        $this->Customer_phone = $Customer_phone;

        return $this;
    }

    public function getCustomerAddress(): ?string
    {
        return $this->Customer_address;
    }

    public function setCustomerAddress(string $Customer_address): self
    {
        $this->Customer_address = $Customer_address;

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
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return (string)$this->getCustomerName();
    }
}
