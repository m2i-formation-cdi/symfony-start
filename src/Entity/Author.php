<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Article;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="author")
     * @var ArrayCollection
     */
    private $articles;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birtDate;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirtDate(): ?\DateTimeInterface
    {
        return $this->birtDate;
    }

    public function setBirtDate(?\DateTimeInterface $birtDate): self
    {
        $this->birtDate = $birtDate;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getArticles(): ArrayCollection
    {
        return $this->articles;
    }


}
