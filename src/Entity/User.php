<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;


#[ApiResource(
    security: "is_granted('ROLE_USER')",
    operations: [
        new Get(
            security: "is_granted('view', object) or is_granted('ROLE_SUPER_ADMIN')",
        ),
        new GetCollection(
            security: "is_granted('ROLE_USER') or is_granted('ROLE_COMPANY_ADMIN') or is_granted('ROLE_SUPER_ADMIN')",

        ),
        new Post(
            security
            : "is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_COMPANY_ADMIN')"
        ),
        new Delete(
            security: "is_granted('ROLE_SUPER_ADMIN')",
        ),
    ]
)]
#[ORM\Entity]
#[ORM\Table(name: "users")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 100)]
    #[Assert\Regex(
        pattern: "/^[A-Z][a-zA-Z ]*$/",
        message: "Name must start with an uppercase letter and contain only letters and spaces."
    )]
    private $name;

    #[ORM\Column(type: "string", length: 20)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ["ROLE_USER", "ROLE_COMPANY_ADMIN", "ROLE_SUPER_ADMIN"])]
    private $role;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Company", inversedBy: "users")]

    private Company $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
