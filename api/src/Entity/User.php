<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get" = { "is_granted('IS_AUTHENTICATED_ANONYMOUSLY')" },
 *          "put" = { "security"="is_granted('ROLE_USER') and object == user" }
 *      },
 *     collectionOperations={
 *          "get" = { "security"="is_granted('ROLE_USER')" },
 *          "post" = {
 *              "security" = "is_granted('IS_AUTHENTICATED_ANONYMOUSLY')",
 *              "validation_groups"={"Default", "create"}
 *          }
 *     },
 * )
 * @ApiFilter(SearchFilter::class, properties={"email": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *      fields={"email"},
 *      message="Email Address is already taken"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @SerializedName("password")
     * @Assert\NotBlank(groups={"create"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Concert", mappedBy="owner", orphanRemoval=true)
     */
    private $conerts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Venue", mappedBy="owner", orphanRemoval=true)
     */
    private $venueList;


    public function __construct()
    {
        $this->conerts = new ArrayCollection();
        $this->venueList = new ArrayCollection();
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Concert[]
     */
    public function getConerts(): Collection
    {
        return $this->conerts;
    }

    public function addConert(Concert $conert): self
    {
        if (!$this->conerts->contains($conert)) {
            $this->conerts[] = $conert;
            $conert->setOwner($this);
        }

        return $this;
    }

    public function removeConert(Concert $conert): self
    {
        if ($this->conerts->contains($conert)) {
            $this->conerts->removeElement($conert);
            // set the owning side to null (unless already changed)
            if ($conert->getOwner() === $this) {
                $conert->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Venue[]
     */
    public function getVenueList(): Collection
    {
        return $this->venueList;
    }

    public function addVenueList(Venue $venueList): self
    {
        if (!$this->venueList->contains($venueList)) {
            $this->venueList[] = $venueList;
            $venueList->setOwner($this);
        }

        return $this;
    }

    public function removeVenueList(Venue $venueList): self
    {
        if ($this->venueList->contains($venueList)) {
            $this->venueList->removeElement($venueList);
            // set the owning side to null (unless already changed)
            if ($venueList->getOwner() === $this) {
                $venueList->setOwner(null);
            }
        }

        return $this;
    }

}
