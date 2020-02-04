<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeZerrendaRepository")
 */
class EmployeeZerrenda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"main", "details"})
     */
    private $id;

    /**
     * @ORM\Column(name="position", type="integer")
     * @Groups({"main", "details"})
     */
    private $position;


    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="employeeZerrenda")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * @Groups({"main","details"})
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zerrenda", inversedBy="employeeZerrenda")
     * @ORM\JoinColumn(name="zerrenda_id", referencedColumnName="id")
     * @Groups({"main", "details"})
     */
    private $zerrenda;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Log", mappedBy="employeezerrenda")
     */
    private $logs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="employeeZerrendas")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calls", mappedBy="employeezerrenda")
     * @Groups({"main", "details"})
     */
    private $calls;

    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->calls = new ArrayCollection();
    }

    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection|Log[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setEmployeezerrenda($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->contains($log)) {
            $this->logs->removeElement($log);
            // set the owning side to null (unless already changed)
            if ($log->getEmployeezerrenda() === $this) {
                $log->setEmployeezerrenda(null);
            }
        }

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

    /**
     * @return Collection|Call[]
     */
    public function getCalls(): Collection
    {
        return $this->calls;
    }

}
