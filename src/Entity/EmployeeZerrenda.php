<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="employeeZerrendas")
     * @Groups({"main", "details"})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calls", mappedBy="employeezerrenda")
     * @Groups({"main", "details"})
     */
    private $calls;

    public function __construct()
    {
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

    public function addCall(Calls $call): self
    {
        if (!$this->calls->contains($call)) {
            $this->calls[] = $call;
            $call->setEmployeezerrenda($this);
        }

        return $this;
    }

    public function removeCall(Calls $call): self
    {
        if ($this->calls->contains($call)) {
            $this->calls->removeElement($call);
            // set the owning side to null (unless already changed)
            if ($call->getEmployeezerrenda() === $this) {
                $call->setEmployeezerrenda(null);
            }
        }

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

}
