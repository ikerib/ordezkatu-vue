<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Zerrenda", inversedBy="jobs")
     * @Groups({"main"})
     */
    private $zerrenda;

    public function __construct()
    {
        $this->zerrenda = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saila", inversedBy="job", cascade={"persist"})
     */
    private $saila;


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
     * @return Collection|Zerrenda[]
     */
    public function getZerrenda(): Collection
    {
        return $this->zerrenda;
    }

    public function addZerrenda(Zerrenda $zerrenda): self
    {
        if (!$this->zerrenda->contains($zerrenda)) {
            $this->zerrenda[] = $zerrenda;
        }

        return $this;
    }

    public function removeZerrenda(Zerrenda $zerrenda): self
    {
        if ($this->zerrenda->contains($zerrenda)) {
            $this->zerrenda->removeElement($zerrenda);
        }

        return $this;
    }

    public function getSaila(): ?Saila
    {
        return $this->saila;
    }

    public function setSaila(?Saila $saila): self
    {
        $this->saila = $saila;

        return $this;
    }

}
