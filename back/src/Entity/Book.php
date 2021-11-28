<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"book", "book:read"}},
 *  denormalizationContext={"groups"={"book", "book:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"title": "ipartial", "author": "ipartial", "genre": "exact"})
 * @ApiFilter(DateFilter::class, properties={"publicationDate"})
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"book", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"book"})
     */
    private $ISBN;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"book", "user:read"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"book", "user:read"})
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"book"})
     */
    private $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"book"})
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"book", "user:read"})
     */
    private $publicationDate;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"book"})
     */
    private $genre;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"book", "user:read"})
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity=Borrowed::class, mappedBy="Book")
     * @Groups({"book"})
     */
    private $borroweds;

    /**
     * @ORM\OneToMany(targetEntity=Reserved::class, mappedBy="Book")
     * @ORM\JoinColumn(nullable=true, onDelete="cascade")
     * @Groups({"book"})
     */
    private $reserveds;

    public function __construct()
    {
        $this->borroweds = new ArrayCollection();
        $this->reserveds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection|Borrowed[]
     */
    public function getBorroweds(): Collection
    {
        return $this->borroweds;
    }

    public function addBorrowed(Borrowed $borrowed): self
    {
        if (!$this->borroweds->contains($borrowed)) {
            $this->borroweds[] = $borrowed;
            $borrowed->setBook($this);
        }

        return $this;
    }

    public function removeBorrowed(Borrowed $borrowed): self
    {
        if ($this->borroweds->removeElement($borrowed)) {
            // set the owning side to null (unless already changed)
            if ($borrowed->getBook() === $this) {
                $borrowed->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reserved[]
     */
    public function getReserveds(): Collection
    {
        return $this->reserveds;
    }

    public function addReserved(Reserved $reserved): self
    {
        if (!$this->reserveds->contains($reserved)) {
            $this->reserveds[] = $reserved;
            $reserved->setBook($this);
        }

        return $this;
    }

    public function removeReserved(Reserved $reserved): self
    {
        if ($this->reserveds->removeElement($reserved)) {
            // set the owning side to null (unless already changed)
            if ($reserved->getBook() === $this) {
                $reserved->setBook(null);
            }
        }

        return $this;
    }
}
