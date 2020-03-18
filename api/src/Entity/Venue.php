<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get" = { "security"="is_granted('ROLE_USER') and object.getOwner() == user" },
 *          "delete" = { "security"="is_granted('ROLE_USER') and object.getOwner() == user" }
 *      },
 *     collectionOperations={
 *          "get" = { "security"="is_granted('ROLE_USER') and object.getOwner() == user" },
 *          "post" = { "security" = "is_granted('ROLE_USER')" }
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\VenueRepository")
 */
class Venue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="venueList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Concert", inversedBy="venue")
     */
    private $concertList;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getConcertList(): ?Concert
    {
        return $this->concertList;
    }

    public function setConcertList(?Concert $concertList): self
    {
        $this->concertList = $concertList;

        return $this;
    }

}
