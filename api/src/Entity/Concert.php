<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_USER')"},
 *     itemOperations={
 *          "get",
 *          "delete",
 *          "put" = { "security"="is_granted('ROLE_USER') and object.owner == user" }
 *      },
 *     collectionOperations={
 *          "get",
 *          "post" = {
 *              "security" = "is_granted('IS_AUTHENTICATED_ANONYMOUSLY')",
 *              "validation_groups"={"Default", "create"}
 *          }
 *     },
 * )
 * @ApiFilter(SearchFilter::class, properties={"owner": "exact"})
 * @ApiFilter(OrderFilter::class, properties={"id", "headliner", "date", "venue", "openingActs"}, arguments={"orderParameterName"="order"})
 * @ORM\Entity(repositoryClass="App\Repository\ConcertRepository")
 */
class Concert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $headliner;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $attended;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $venue;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $openingActs = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="conerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    public function __construct()
    {
        $this->owner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeadliner(): ?string
    {
        return $this->headliner;
    }

    public function setHeadliner(string $headliner): self
    {
        $this->headliner = $headliner;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAttended(): ?bool
    {
        return $this->attended;
    }

    public function setAttended(bool $attended): self
    {
        $this->attended = $attended;

        return $this;
    }

    public function getVenue(): ?string
    {
        return $this->venue;
    }

    public function setVenue(string $venue): self
    {
        $this->venue = $venue;

        return $this;
    }

    public function getOpeningActs(): ?array
    {
        return $this->openingActs;
    }

    public function setOpeningActs(?array $openingActs): self
    {
        $this->openingActs = $openingActs;

        return $this;
    }


    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
