<?php
/**
 * Owner model
 * Represents the owner of a project
 */

declare(strict_types=1);

namespace App\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('owners')]
class Owner
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column]
    private string $name;

    #[Column]
    private string $email;

    #[OneToMany(targetEntity: Project::class, mappedBy: 'owner', cascade: ['persist'])]
    private Collection $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function __invoke(): Owner
    {
        return $this;
    }

    public function setId(int $id): Owner
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $name
     * @return Owner
     */
    public function setName(string $name): Owner
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $email
     * @return Owner
     */
    public function setEmail(string $email): Owner
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param Project $project
     * @return Owner
     */
    public function addProject(Project $project): Owner
    {
        $project->setOwner($this);

        $this->projects[] = $project;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProjects(): Collection
    {
        return  $this->projects;
    }
}
