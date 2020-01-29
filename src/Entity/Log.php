<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 */
class Log
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"main"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"main"})
     */
    private $description;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"main"})
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="logs", cascade={"persist"})
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zerrenda", inversedBy="logs", cascade={"persist"})
     */
    private $zerrenda;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EmployeeZerrenda", inversedBy="logs", cascade={"persist"})
     */
    private $employeezerrenda;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="logs", cascade={"persist"})
     * @Groups({"main"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="logs")
     * @Groups({"main"})
     */
    private $result;


    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getEmployeezerrenda(): ?EmployeeZerrenda
    {
        return $this->employeezerrenda;
    }

    public function setEmployeezerrenda(?EmployeeZerrenda $employeezerrenda): self
    {
        $this->employeezerrenda = $employeezerrenda;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getResult(): ?Type
    {
        return $this->result;
    }

    public function setResult(?Type $result): self
    {
        $this->result = $result;

        return $this;
    }


}
