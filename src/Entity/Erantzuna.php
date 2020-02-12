<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ErantzunaRepository")
 */
class Erantzuna
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
    private $color;

    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/
    /************************************************************************************************************************************************************************************/

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calls", mappedBy="erantzuna")
     */
    private $calls;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JobDetail", mappedBy="lastErantzuna")
     */
    private $jobDetails;

    public function __construct()
    {
        $this->calls = new ArrayCollection();
        $this->jobDetails = new ArrayCollection();
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
            $call->setErantzuna($this);
        }

        return $this;
    }

    public function removeCall(Calls $call): self
    {
        if ($this->calls->contains($call)) {
            $this->calls->removeElement($call);
            // set the owning side to null (unless already changed)
            if ($call->getErantzuna() === $this) {
                $call->setErantzuna(null);
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
            $jobDetail->setLastErantzuna($this);
        }

        return $this;
    }

    public function removeJobDetail(JobDetail $jobDetail): self
    {
        if ($this->jobDetails->contains($jobDetail)) {
            $this->jobDetails->removeElement($jobDetail);
            // set the owning side to null (unless already changed)
            if ($jobDetail->getLastErantzuna() === $this) {
                $jobDetail->setLastErantzuna(null);
            }
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
