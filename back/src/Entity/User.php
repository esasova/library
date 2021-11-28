<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Controller\Action\GetMeAction;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *          "get",
 *          "post"={"route_name"="api_users_post"}
 *     },
 *  itemOperations={
 *         "get"={
 *             "requirements"={"id"="\d+"}
 *         },
 *          "put"={"route_name"="api_users_put"},
 *          "delete",
 *          "get_me"={
 *             "method"="GET",
 *             "path"="/users/me",
 *             "controller"=GetMeAction::class,
 *             "openapi_context"={
 *                 "parameters"={}
 *             },
 *             "read"=false
 *         }
 *     },
 *  normalizationContext={"groups"={"user", "user:read"}},
 *  denormalizationContext={"groups"={"user", "user:write"}},
 * )
 * @ApiFilter(SearchFilter::class, properties={"surname": "ipartial"})
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user", "book:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"user", "book:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"user", "book:read"})
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user"})
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user"})
     */
    private $isValidated;

    /**
     * @ORM\OneToMany(targetEntity=Reserved::class, mappedBy="User")
     * @ORM\JoinColumn(nullable=true, onDelete="cascade")
     * @Groups({"user"})

     */
    private $reserveds;

    /**
     * @ORM\OneToMany(targetEntity=Borrowed::class, mappedBy="User")
     * @Groups({"user"})
     */
    private $borroweds;

    public function __construct()
    {
        $this->borroweds = new ArrayCollection();
        $this->reserveds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): self
    {
        $this->isValidated = $isValidated;

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
            $borrowed->setUser($this);
        }

        return $this;
    }

    public function removeBorrowed(Borrowed $borrowed): self
    {
        if ($this->borroweds->removeElement($borrowed)) {
            // set the owning side to null (unless already changed)
            if ($borrowed->getUser() === $this) {
                $borrowed->setUser(null);
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
            $reserved->setUser($this);
        }

        return $this;
    }

    public function removeReserved(Reserved $reserved): self
    {
        if ($this->reserveds->removeElement($reserved)) {
            // set the owning side to null (unless already changed)
            if ($reserved->getUser() === $this) {
                $reserved->setUser(null);
            }
        }

        return $this;
    }
}
