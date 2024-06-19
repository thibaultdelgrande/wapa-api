<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PanneauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanneauRepository::class)]
#[ApiResource]
class Panneau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $codeDep = null;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $codeCirco = null;

    #[ORM\Column(nullable: true)]
    private ?int $codeCom = null;

    /**
     * @var Collection<int, Action>
     */
    #[ORM\OneToMany(targetEntity: Action::class, mappedBy: 'panneau', orphanRemoval: true)]
    private Collection $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCodeDep(): ?int
    {
        return $this->codeDep;
    }

    public function setCodeDep(?int $codeDep): static
    {
        $this->codeDep = $codeDep;

        return $this;
    }

    public function getCodeCirco(): ?string
    {
        return $this->codeCirco;
    }

    public function setCodeCirco(?string $codeCirco): static
    {
        $this->codeCirco = $codeCirco;

        return $this;
    }

    public function getCodeCom(): ?int
    {
        return $this->codeCom;
    }

    public function setCodeCom(?int $codeCom): static
    {
        $this->codeCom = $codeCom;

        return $this;
    }

    /**
     * @return Collection<int, Action>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): static
    {
        if (!$this->actions->contains($action)) {
            $this->actions->add($action);
            $action->setPanneau($this);
        }

        return $this;
    }

    public function removeAction(Action $action): static
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getPanneau() === $this) {
                $action->setPanneau(null);
            }
        }

        return $this;
    }

    public function getLastAction(): ?Action
    {
        $lastAction = null;
        $maxTimestamp = null;

        foreach ($this->actions as $action) {
            if ($maxTimestamp === null || $action->getTimestamp() > $maxTimestamp) {
                $maxTimestamp = $action->getTimestamp();
                $lastAction = $action;
            }
        }

        return $lastAction;
    }
}
