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
     * @Groups({"main", "details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"main", "details"})
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"main", "details"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"main", "details"})
     */
    private $endDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"main", "details"})
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"main", "details"})
     */
    private $eginkizunak;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"main", "details"})
     */
    private $bestebatzuk;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"main", "details"})
     */
    private $isUserEditable;

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

    public function __construct()
    {
        $this->jobZerrendaEmployees = new ArrayCollection();
        $this->setIsUserEditable( true );
        $this->startDate = new \DateTime();
        $this->endDate = new \DateTime();
        $this->jobDetails = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saila", inversedBy="job", cascade={"persist"})
     */
    private $saila;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="jobs")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Arrazoia", inversedBy="jobs")
     */
    private $arrazoia;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JobType", inversedBy="job")
     */
    private $jobType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SailkapenTaldea", inversedBy="jobs")
     */
    private $sailkapenTalea;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JobType", inversedBy="jobs")
     */
    private $izendapenMota;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hizkuntza", inversedBy="jobs")
     */
    private $hizkuntza;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Titulazioa", inversedBy="jobs")
     */
    private $titulazioa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eskatutakoTitulazioa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JobDetail", mappedBy="job")
     * @Groups({"main"})
     */
    private $jobDetails;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getArrazoia(): ?Arrazoia
    {
        return $this->arrazoia;
    }

    public function setArrazoia(?Arrazoia $arrazoia): self
    {
        $this->arrazoia = $arrazoia;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getJobType(): ?JobType
    {
        return $this->jobType;
    }

    public function setJobType(?JobType $jobType): self
    {
        $this->jobType = $jobType;

        return $this;
    }

    public function getEginkizunak(): ?string
    {
        return $this->eginkizunak;
    }

    public function setEginkizunak(?string $eginkizunak): self
    {
        $this->eginkizunak = $eginkizunak;

        return $this;
    }

    public function getSailkapenTalea(): ?SailkapenTaldea
    {
        return $this->sailkapenTalea;
    }

    public function setSailkapenTalea(?SailkapenTaldea $sailkapenTalea): self
    {
        $this->sailkapenTalea = $sailkapenTalea;

        return $this;
    }

    public function getIzendapenMota(): ?JobType
    {
        return $this->izendapenMota;
    }

    public function setIzendapenMota(?JobType $izendapenMota): self
    {
        $this->izendapenMota = $izendapenMota;

        return $this;
    }

    public function getHizkuntza(): ?Hizkuntza
    {
        return $this->hizkuntza;
    }

    public function setHizkuntza(?Hizkuntza $hizkuntza): self
    {
        $this->hizkuntza = $hizkuntza;

        return $this;
    }

    public function getTitulazioa(): ?Titulazioa
    {
        return $this->titulazioa;
    }

    public function setTitulazioa(?Titulazioa $titulazioa): self
    {
        $this->titulazioa = $titulazioa;

        return $this;
    }

    public function getBestebatzuk(): ?string
    {
        return $this->bestebatzuk;
    }

    public function setBestebatzuk(?string $bestebatzuk): self
    {
        $this->bestebatzuk = $bestebatzuk;

        return $this;
    }

    public function getIsUserEditable(): ?bool
    {
        return $this->isUserEditable;
    }

    public function setIsUserEditable(bool $isUserEditable): self
    {
        $this->isUserEditable = $isUserEditable;

        return $this;
    }

    public function getEskatutakoTitulazioa(): ?string
    {
        return $this->eskatutakoTitulazioa;
    }

    public function setEskatutakoTitulazioa(?string $eskatutakoTitulazioa): self
    {
        $this->eskatutakoTitulazioa = $eskatutakoTitulazioa;

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
            $jobDetail->setJob($this);
        }

        return $this;
    }

    public function removeJobDetail(JobDetail $jobDetail): self
    {
        if ($this->jobDetails->contains($jobDetail)) {
            $this->jobDetails->removeElement($jobDetail);
            // set the owning side to null (unless already changed)
            if ($jobDetail->getJob() === $this) {
                $jobDetail->setJob(null);
            }
        }

        return $this;
    }

}
