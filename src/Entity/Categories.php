<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderView;

    /**
     * @ORM\OneToMany(targetEntity=Entries::class, mappedBy="category")
     */
    private $entries;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $ID): self
    {
        $this->ID = $ID;

        return $this;
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

    public function getOrderView(): ?int
    {
        return $this->orderView;
    }

    public function setOrderView(int $orderView): self
    {
        $this->orderView = $orderView;

        return $this;
    }

    /**
     * @return Collection|Entries[]
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(Entries $entry): self
    {
        if (!$this->entries->contains($entry)) {
            $this->entries[] = $entry;
            $entry->setCategory($this);
        }

        return $this;
    }

    public function removeEntry(Entries $entry): self
    {
        if ($this->entries->removeElement($entry)) {
            // set the owning side to null (unless already changed)
            if ($entry->getCategory() === $this) {
                $entry->setCategory(null);
            }
        }

        return $this;
    }
}
