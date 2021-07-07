<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZerrendaRepository")
 * @Vich\Uploadable
 */
class Zerrenda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"main", "details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"main", "details"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"main", "details"})
     */
    private $fitxategia;

    /**
     * @Vich\UploadableField(mapping="zerrenda_employee", fileNameProperty="fitxategia")
     */
    private $fitxategiaFile;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"main", "details"})
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"main", "details"})
     */
    private $updated;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Job", mappedBy="zerrenda")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeZerrenda", mappedBy="zerrenda")
     * @ORM\OrderBy({"position"="ASC"})
     * @Groups({"details"})
     */
    private $employeeZerrenda;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmployeeZerrendaType", mappedBy="zerrenda")
     */
    private $employeeZerrendaTypes;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->employeeZerrenda = new ArrayCollection();
        $this->employeeZerrendaTypes = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function setFitxategiaFile(File $fitxategia = null): void
    {
        $this->fitxategiaFile = $fitxategia;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($fitxategia) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updated = new \DateTime('now');
        }
    }

    public function getFitxategiaFile()
    {
        return $this->fitxategiaFile;
    }

    public function setFitxategia($fitxategia): void
    {
        $this->fitxategia = $fitxategia;
    }

    public function getFitxategia()
    {
        return $this->fitxategia;
    }

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

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

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->addZerrenda($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            $job->removeZerrenda($this);
        }

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
            $employeeZerrenda->setZerrenda($this);
        }

        return $this;
    }

    public function removeEmployeeZerrenda(EmployeeZerrenda $employeeZerrenda): self
    {
        if ($this->employeeZerrenda->contains($employeeZerrenda)) {
            $this->employeeZerrenda->removeElement($employeeZerrenda);
            // set the owning side to null (unless already changed)
            if ($employeeZerrenda->getZerrenda() === $this) {
                $employeeZerrenda->setZerrenda(null);
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
            $employeeZerrendaType->setZerrenda($this);
        }

        return $this;
    }

    public function removeEmployeeZerrendaType(EmployeeZerrendaType $employeeZerrendaType): self
    {
        if ($this->employeeZerrendaTypes->contains($employeeZerrendaType)) {
            $this->employeeZerrendaTypes->removeElement($employeeZerrendaType);
            // set the owning side to null (unless already changed)
            if ($employeeZerrendaType->getZerrenda() === $this) {
                $employeeZerrendaType->setZerrenda(null);
            }
        }

        return $this;
    }
}
