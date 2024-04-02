<?php

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
#[Table('statuses')]
class Status
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;
    #[Column]
    private string $key;

    #[Column]
    private string $name;

    #[OneToMany(targetEntity: Project::class, mappedBy: 'status', cascade: ['persist'])]
    private Collection $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function __invoke(): Status
    {
        return $this;
    }

    /**
     * Get the Status ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the Status ID
     * @param int $id
     * @return Status
     */
    public function setId(int $id): Status
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the Status key
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set the Status key
     * @param string $key
     * @return Status
     */
    public function setKey(string $key): Status
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the Status name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the Status name
     * @param string $name
     * @return Status
     */
    public function setName(string $name): Status
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add a project to the status
     * @param Project $project
     * @return Status
     */
    public function addProject(Project $project): Status
    {
        $project->setStatus($this);

        $this->projects[] = $project;

        return $this;
    }

    /**
     * Get the projects associated with the status
     * @return Collection
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }
}
