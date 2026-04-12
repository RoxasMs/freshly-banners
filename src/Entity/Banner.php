<?php

namespace App\Entity;

use App\Repository\BannerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BannerRepository::class)]
class Banner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255)]
    private ?string $internal_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $end_date = null;

    /**
     * @var Collection<int, BannerContent>
     */
    #[ORM\OneToMany(targetEntity: BannerContent::class, mappedBy: 'banner', orphanRemoval: true)]
    private Collection $bannerContents;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Color $background_color = null;

    public function __construct()
    {
        $this->bannerContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getInternalName(): ?string
    {
        return $this->internal_name;
    }

    public function setInternalName(string $internal_name): static
    {
        $this->internal_name = $internal_name;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTime $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection<int, BannerContent>
     */
    public function getBannerContents(): Collection
    {
        return $this->bannerContents;
    }

    public function addBannerContent(BannerContent $bannerContent): static
    {
        if (!$this->bannerContents->contains($bannerContent)) {
            $this->bannerContents->add($bannerContent);
            $bannerContent->setBanner($this);
        }

        return $this;
    }

    public function removeBannerContent(BannerContent $bannerContent): static
    {
        if ($this->bannerContents->removeElement($bannerContent)) {
            // set the owning side to null (unless already changed)
            if ($bannerContent->getBanner() === $this) {
                $bannerContent->setBanner(null);
            }
        }

        return $this;
    }

    public function getBackgroundColor(): ?Color
    {
        return $this->background_color;
    }

    public function setBackgroundColor(?Color $background_color): static
    {
        $this->background_color = $background_color;

        return $this;
    }
}
