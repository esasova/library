<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReservedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ReservedRepository::class)
 */
class Reserved
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read", "book:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user:read", "book:read"})
     */
    private $start;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user:read", "book:read"})
     */
    private $end;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="reserveds")
     * @Groups({"user:read"})
     */
    private $Book;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reserveds")
     * @Groups({"book:read"})
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->Book;
    }

    public function setBook(?Book $Book): self
    {
        $this->Book = $Book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
