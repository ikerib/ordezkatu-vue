<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArrazoiaRepository")
 */
class Arrazoia
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
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"main"})
     */
    private $aldibaterako;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="arrazoia")
     */
    private $jobs;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
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

    public function getAldibaterako(): ?bool
    {
        return $this->aldibaterako;
    }

    public function setAldibaterako(?bool $aldibaterako): self
    {
        $this->aldibaterako = $aldibaterako;

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
            $job->setArrazoia($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getArrazoia() === $this) {
                $job->setArrazoia(null);
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
