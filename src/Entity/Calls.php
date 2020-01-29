<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CallsRepository")
 */
class Calls
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"main"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"main"})
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"main"})
     */
    private $updated;

    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EmployeeZerrenda", inversedBy="calls")
     */
    private $employeezerrenda;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="calls")
     */
    private $result;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="calls")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="calls")
     */
    private $employee;

    public function __construct()
    {
        $this->created = New \DateTime();
        $this->updated = New \DateTime();
    }


    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

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

    public function getResult(): ?Type
    {
        return $this->result;
    }

    public function setResult(?Type $result): self
    {
        $this->result = $result;

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

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }
}
