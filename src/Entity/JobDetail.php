<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobDetailRepository")
 */
class JobDetail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"main", "details"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"main", "details"})
     */
    private $position;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="date", nullable=true)
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="jobDetails")
     */
    private $job;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="jobDetails")
     * @Groups({"main"})
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calls", mappedBy="jobdetail")
     * @Groups({"main", "details"})
     */
    private $calls;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Erantzuna", inversedBy="jobDetails")
     * @Groups({"main", "details"})
     */
    private $lastErantzuna;

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

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

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
            $call->setJobdetail($this);
        }

        return $this;
    }

    public function removeCall(Calls $call): self
    {
        if ($this->calls->contains($call)) {
            $this->calls->removeElement($call);
            // set the owning side to null (unless already changed)
            if ($call->getJobdetail() === $this) {
                $call->setJobdetail(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getLastErantzuna(): ?Erantzuna
    {
        return $this->lastErantzuna;
    }

    public function setLastErantzuna(?Erantzuna $lastErantzuna): self
    {
        $this->lastErantzuna = $lastErantzuna;

        return $this;
    }
}
