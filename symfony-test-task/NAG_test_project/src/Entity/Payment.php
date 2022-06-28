<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $summa;

    #[ORM\Column(type: 'date')]
    private $data;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'payments')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Acnt::class, inversedBy: 'payments')]
    private $acnt;

    #[ORM\ManyToOne(targetEntity: Pay::class, inversedBy: 'payments')]
    private $pay;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSumma(): ?float
    {
        return $this->summa;
    }

    public function setSumma(float $summa): self
    {
        $this->summa = $summa;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAcnt(): ?Acnt
    {
        return $this->acnt;
    }

    public function setAcnt(?Acnt $acnt): self
    {
        $this->acnt = $acnt;

        return $this;
    }

    public function getPay(): ?Pay
    {
        return $this->pay;
    }

    public function setPay(?Pay $pay): self
    {
        $this->pay = $pay;

        return $this;
    }
}
