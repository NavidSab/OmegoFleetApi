<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;


#[ApiResource(
    security: "is_granted('ROLE_USER')",
    operations: [
        new Get(
            security: "is_granted('ROLE_USER') or is_granted('ROLE_COMPANY_ADMIN') or is_granted('ROLE_SUPER_ADMIN')",
        ),
        new GetCollection(
            security: "is_granted('ROLE_USER') or is_granted('ROLE_COMPANY_ADMIN') or is_granted('ROLE_SUPER_ADMIN')",

        ),
        new Post(
            security
            : "is_granted('ROLE_SUPER_ADMIN')"
        ),
    ]
)]

#[ORM\Entity]
#[UniqueEntity(fields: ['name'], message: 'The name must be unique')]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 100, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 100)]
    private $name;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'company')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

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
}
