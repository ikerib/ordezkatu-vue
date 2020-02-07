<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeZerrendaTypeRepository")
 * @Vich\Uploadable
 */
class EmployeeZerrendaType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"main", "details"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"main", "details"})
     */
    private $notes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"main", "details"})
     */
    private $lastPosition;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"main", "details"})
     */
    private $currentPosition;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"main", "details"})
     */
    private $document;

    /**
     * @Vich\UploadableField(mapping="uploadfile", fileNameProperty="document")
     * @Groups({"main", "details"})
     */
    private $documentFile;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="employeeZerrendaTypes")
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zerrenda", inversedBy="employeeZerrendaTypes")
     */
    private $zerrenda;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="lastemployeeZerrendaTypes")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="employeeZerrendaTypes")
     */
    private $last;

    public function __construct() { }

    public function __toString()
    {
        return $this->employee . ' - ' . $this->zerrenda;
    }

    public function setDocumentFile(File $document = null): void
    {
        $this->documentFile = $document;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($document) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updated = new \DateTime('now');
        }
    }

    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(string $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getZerrenda(): ?Zerrenda
    {
        return $this->zerrenda;
    }

    public function setZerrenda(?Zerrenda $zerrenda): self
    {
        $this->zerrenda = $zerrenda;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getLast(): ?Type
    {
        return $this->last;
    }

    public function setLast(?Type $last): self
    {
        $this->last = $last;

        return $this;
    }

    public function getLastPosition(): ?int
    {
        return $this->lastPosition;
    }

    public function setLastPosition(?int $lastPosition): self
    {
        $this->lastPosition = $lastPosition;

        return $this;
    }

    public function getCurrentPosition(): ?int
    {
        return $this->currentPosition;
    }

    public function setCurrentPosition(?int $currentPosition): self
    {
        $this->currentPosition = $currentPosition;

        return $this;
    }




}
