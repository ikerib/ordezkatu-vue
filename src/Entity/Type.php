<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="orden", type="integer", nullable=true)
     * @Groups({"main"})
     */
    private $orden;

//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="type")
//     */
//    private $employees;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeZerrendaType", mappedBy="type")
     */
    private $employeeZerrendaTypes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeZerrendaType", mappedBy="last")
     */
    private $lastemployeeZerrendaTypes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeZerrenda", mappedBy="type")
     */
    private $employeeZerrendas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calls", mappedBy="result")
     */
    private $calls;

    public function __construct()
    {
//        $this->employees = new ArrayCollection();
        $this->employeeZerrendaTypes = new ArrayCollection();
        $this->employeeZerrendas = new ArrayCollection();
        $this->calls = new ArrayCollection();
        $this->lastemployeeZerrendaTypes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setOrden(?int $orden): self
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->setType($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->contains($employee)) {
            $this->employees->removeElement($employee);
            // set the owning side to null (unless already changed)
            if ($employee->getType() === $this) {
                $employee->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EmployeeZerrendaType[]
     */
    public function getEmployeeZerrendaTypes(): Collection
    {
        return $this->employeeZerrendaTypes;
    }

    public function addEmployeeZerrendaType(EmployeeZerrendaType $employeeZerrendaType): self
    {
        if (!$this->employeeZerrendaTypes->contains($employeeZerrendaType)) {
            $this->employeeZerrendaTypes[] = $employeeZerrendaType;
            $employeeZerrendaType->setType($this);
        }

        return $this;
    }

    public function removeEmployeeZerrendaType(EmployeeZerrendaType $employeeZerrendaType): self
    {
        if ($this->employeeZerrendaTypes->contains($employeeZerrendaType)) {
            $this->employeeZerrendaTypes->removeElement($employeeZerrendaType);
            // set the owning side to null (unless already changed)
            if ($employeeZerrendaType->getType() === $this) {
                $employeeZerrendaType->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EmployeeZerrenda[]
     */
    public function getEmployeeZerrendas(): Collection
    {
        return $this->employeeZerrendas;
    }

    public function addEmployeeZerrenda(EmployeeZerrenda $employeeZerrenda): self
    {
        if (!$this->employeeZerrendas->contains($employeeZerrenda)) {
            $this->employeeZerrendas[] = $employeeZerrenda;
            $employeeZerrenda->setType($this);
        }

        return $this;
    }

    public function removeEmployeeZerrenda(EmployeeZerrenda $employeeZerrenda): self
    {
        if ($this->employeeZerrendas->contains($employeeZerrenda)) {
            $this->employeeZerrendas->removeElement($employeeZerrenda);
            // set the owning side to null (unless already changed)
            if ($employeeZerrenda->getType() === $this) {
                $employeeZerrenda->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Calls[]
     */
    public function getCalls(): Collection
    {
        return $this->calls;
    }

    public function addCall(Calls $call): self
    {
        if (!$this->calls->contains($call)) {
            $this->calls[] = $call;
            $call->setResult($this);
        }

        return $this;
    }

    public function removeCall(Calls $call): self
    {
        if ($this->calls->contains($call)) {
            $this->calls->removeElement($call);
            // set the owning side to null (unless already changed)
            if ($call->getResult() === $this) {
                $call->setResult(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EmployeeZerrendaType[]
     */
    public function getLastemployeeZerrendaTypes(): Collection
    {
        return $this->lastemployeeZerrendaTypes;
    }

    public function addLastemployeeZerrendaType(EmployeeZerrendaType $lastemployeeZerrendaType): self
    {
        if (!$this->lastemployeeZerrendaTypes->contains($lastemployeeZerrendaType)) {
            $this->lastemployeeZerrendaTypes[] = $lastemployeeZerrendaType;
            $lastemployeeZerrendaType->setLast($this);
        }

        return $this;
    }

    public function removeLastemployeeZerrendaType(EmployeeZerrendaType $lastemployeeZerrendaType): self
    {
        if ($this->lastemployeeZerrendaTypes->contains($lastemployeeZerrendaType)) {
            $this->lastemployeeZerrendaTypes->removeElement($lastemployeeZerrendaType);
            // set the owning side to null (unless already changed)
            if ($lastemployeeZerrendaType->getLast() === $this) {
                $lastemployeeZerrendaType->setLast(null);
            }
        }

        return $this;
    }

}
