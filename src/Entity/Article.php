<?php

namespace App\Entity;

use App\Entity\Author;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @Gedmo\Uploadable(path="img/photos", allowOverwrite=true, filenameGenerator="SHA1", appendNumber=true)
 */
class Article extends Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;


    /**
     * @ORM\Column(type="string", nullable=true)
     * @Gedmo\UploadableFileName()
     * @var string
     */
    private $image;

    /**
     * @var UploadedFile
     * @Assert\File()
     *
     */
    private $uploadedFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Author",
     *     inversedBy="articles", cascade={"persist"}, fetch="EAGER")
     * @var Author
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles",
     *     fetch="EAGER", cascade={"persist"})
     * @var ArrayCollection
     */
    private $tags;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     */
    private $comments;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     * @return Article
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): Article
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Author
     */
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    /**
     * @param Author $author
     * @return Article
     */
    public function setAuthor(Author $author): Article
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersistEvent(){
        $date = new \DateTime();
        $this->createdAt = $date;
        $this->updatedAt = $date;
    }

    /***
     * @ORM\PreUpdate()
     * @throws \Exception
     */
    public function preUpdateEvent(){
        $date = new \DateTime();
        $this->updatedAt = $date;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Article
     */
    public function setSlug(string $slug): Article
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Article
     */
    public function setImage(string $image): Article
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile(): ? UploadedFile
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return Article
     */
    public function setUploadedFile(UploadedFile $uploadedFile): Article
    {
        $this->uploadedFile = $uploadedFile;
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }



}
