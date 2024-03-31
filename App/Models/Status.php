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

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Status
    {
        $this->id = $id;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): Status
    {
        $this->key = $key;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Status
    {
        $this->name = $name;

        return $this;
    }

    public function addProject(Project $project): Status
    {
        $project->setStatus($this);

        $this->projects[] = $project;

        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }
}
