<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"main"})
     */
    private $notes;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"main"})
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"main"})
     */
    private $updated;

    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="calls")
     * @Groups({"main"})
     */
    private $employees;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="calls")
     * @Groups({"main"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Erantzuna", inversedBy="calls")
     * @Groups({"main"})
     */
    private $erantzuna;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JobDetail", inversedBy="calls")
     */
    private $jobdetail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $justifyNeed;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $justified;

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

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getErantzuna(): ?Erantzuna
    {
        return $this->erantzuna;
    }

    public function setErantzuna(?Erantzuna $erantzuna): self
    {
        $this->erantzuna = $erantzuna;

        return $this;
    }

    public function getJobdetail(): ?JobDetail
    {
        return $this->jobdetail;
    }

    public function setJobdetail(?JobDetail $jobdetail): self
    {
        $this->jobdetail = $jobdetail;

        return $this;
    }

    public function getEmployees(): ?Employee
    {
        return $this->employees;
    }

    public function setEmployees(?Employee $employees): self
    {
        $this->employees = $employees;

        return $this;
    }

    public function getJustifyNeed(): ?bool
    {
        return $this->justifyNeed;
    }

    public function setJustifyNeed(?bool $justifyNeed): self
    {
        $this->justifyNeed = $justifyNeed;

        return $this;
    }

    public function getJustified(): ?bool
    {
        return $this->justified;
    }

    public function setJustified(?bool $justified): self
    {
        $this->justified = $justified;

        return $this;
    }
}
