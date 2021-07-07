<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
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
     * @ORM\Column(type="string", length=255)
     * @Groups({"main"})
     */
    private $abizena1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"main"})
     */
    private $abizena2;

    /**
     * @ORM\Column(type="string", length=15, unique=true)
     * @Groups({"main"})
     */
    private $nan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"main"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"main"})
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $helbidea;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elkarkidetza;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Municipio", inversedBy="employees")
     * @Groups({"main"})
     */
    private $municipio;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeZerrenda", mappedBy="employee")
     */
    private $employeeZerrenda;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeZerrendaType", mappedBy="employee")
     */
    private $employeeZerrendaTypes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calls", mappedBy="employees")
     */
    private $calls;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JobDetail", mappedBy="employee")
     */
    private $jobDetails;

    public function __construct()
    {
        $this->employeeZerrenda = new ArrayCollection();
        $this->employeeZerrendaTypes = new ArrayCollection();
        $this->calls = new ArrayCollection();
        $this->jobDetails = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName() . ' ' . $this->getAbizena1() . ' ' . $this->getAbizena2();
    }

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

    public function getAbizena1(): ?string
    {
        return $this->abizena1;
    }

    public function setAbizena1(string $abizena1): self
    {
        $this->abizena1 = $abizena1;

        return $this;
    }

    public function getAbizena2(): ?string
    {
        return $this->abizena2;
    }

    public function setAbizena2(string $abizena2): self
    {
        $this->abizena2 = $abizena2;

        return $this;
    }

    public function getNan(): ?string
    {
        return $this->nan;
    }

    public function setNan(string $nan): self
    {
        $this->nan = $nan;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getHelbidea(): ?string
    {
        return $this->helbidea;
    }

    public function setHelbidea(?string $helbidea): self
    {
        $this->helbidea = $helbidea;

        return $this;
    }

    public function getCreated(): ?DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getMunicipio(): ?Municipio
    {
        return $this->municipio;
    }

    public function setMunicipio(?Municipio $municipio): self
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * @return Collection|EmployeeZerrenda[]
     */
    public function getEmployeeZerrenda(): Collection
    {
        return $this->employeeZerrenda;
    }

    public function addEmployeeZerrenda(EmployeeZerrenda $employeeZerrenda): self
    {
        if (!$this->employeeZerrenda->contains($employeeZerrenda)) {
            $this->employeeZerrenda[] = $employeeZerrenda;
            $employeeZerrenda->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeZerrenda(EmployeeZerrenda $employeeZerrenda): self
    {
        if ($this->employeeZerrenda->contains($employeeZerrenda)) {
            $this->employeeZerrenda->removeElement($employeeZerrenda);
            // set the owning side to null (unless already changed)
            if ($employeeZerrenda->getEmployee() === $this) {
                $employeeZerrenda->setEmployee(null);
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
            $employeeZerrendaType->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeZerrendaType(EmployeeZerrendaType $employeeZerrendaType): self
    {
        if ($this->employeeZerrendaTypes->contains($employeeZerrendaType)) {
            $this->employeeZerrendaTypes->removeElement($employeeZerrendaType);
            // set the owning side to null (unless already changed)
            if ($employeeZerrendaType->getEmployee() === $this) {
                $employeeZerrendaType->setEmployee(null);
            }
        }

        return $this;
    }

    public function getElkarkidetza(): ?bool
    {
        return $this->elkarkidetza;
    }

    public function setElkarkidetza(bool $elkarkidetza): self
    {
        $this->elkarkidetza = $elkarkidetza;

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
            $call->setEmployee($this);
        }

        return $this;
    }

    public function removeCall(Calls $call): self
    {
        if ($this->calls->contains($call)) {
            $this->calls->removeElement($call);
            // set the owning side to null (unless already changed)
            if ($call->getEmployee() === $this) {
                $call->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|JobDetail[]
     */
    public function getJobDetails(): Collection
    {
        return $this->jobDetails;
    }

    public function addJobDetail(JobDetail $jobDetail): self
    {
        if (!$this->jobDetails->contains($jobDetail)) {
            $this->jobDetails[] = $jobDetail;
            $jobDetail->setEmployee($this);
        }

        return $this;
    }

    public function removeJobDetail(JobDetail $jobDetail): self
    {
        if ($this->jobDetails->contains($jobDetail)) {
            $this->jobDetails->removeElement($jobDetail);
            // set the owning side to null (unless already changed)
            if ($jobDetail->getEmployee() === $this) {
                $jobDetail->setEmployee(null);
            }
        }

        return $this;
    }

}
