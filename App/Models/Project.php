<?php
/**
 * Project model
 * Represents a project
 */
declare(strict_types=1);

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

    /**
     * Get the project ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the project ID
     * @param int $id
     * @return Project
     */
    public function setId(int $id): Project
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the status ID
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->statusId;
    }

    /**
     * Set the status ID
     * @param int $statusId
     * @return Project
     */
    public function setStatusId(int $statusId): Project
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * Get the project title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the project title
     * @param string $title
     * @return Project
     */
    public function setTitle(string $title): Project
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the project description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the project description
     * @param string $description
     * @return Project
     */
    public function setDescription(string $description): Project
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the Project status object
     * @param Status $status
     * @return Project
     */
    public function setStatus(Status $status): Project
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the Project status object
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * Set the Project owner object
     * @param Owner $owner
     * @return Project
     */
    public function setOwner(Owner $owner): Project
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get the Project owner object
     * @return Owner
     */
    public function getOwner(): Owner
    {
        return $this->owner;
    }

}
