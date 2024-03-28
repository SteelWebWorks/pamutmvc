<?php

namespace App\Models;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('projects')]
class Project
{

    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(name: 'status_id')]
    private int $statusId;

    #[Column(name: 'owner_id')]
    private int $ownerId;

    public function __invoke(): Project
    {
        return $this;
    }
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): Project
    {
        $this->ownerId = $ownerId;

        return $this;
    }
    #[Column]
    private string $title;

    #[Column]
    private string $description;

    #[ManyToOne(cascade: ['persist'], inversedBy: 'projects')]
    #[JoinColumn(name: "status_id", referencedColumnName: "id", nullable: false)]
    private Status $status;

    #[ManyToOne(cascade: ['persist'], inversedBy: 'projects')]
    #[JoinColumn(name: "owner_id", referencedColumnName: "id", nullable: false)]
    private Owner $owner;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Project
    {
        $this->id = $id;

        return $this;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }

    public function setStatusId(int $statusId): Project
    {
        $this->statusId = $statusId;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Project
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Project
    {
        $this->description = $description;

        return $this;
    }

    public function setStatus(Status $status): Project
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
    public function setOwner(Owner $owner): Project
    {
        $this->owner = $owner;

        return $this;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

}
