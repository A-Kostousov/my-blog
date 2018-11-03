<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $postTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="9000")
     */
    private $postText;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="content", orphanRemoval=true)
     */
    private $CommentsPost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->CommentsPost = new ArrayCollection();
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

    public function getPostTitle(): ?string
    {
        return $this->postTitle;
    }

    public function setPostTitle(string $title): self
    {
        $this->postTitle = $title;

        return $this;
    }

    public function getPostText(): ?string

    {
        return $this->postText;
    }

    public function setPostText(?string $text): self
    {
        $this->postText = $text;

        return $this;
    }

    public function getShortPostText(): ?string {
        if (mb_strlen($this->postText) <= 80) {
            return $this->postText;
        }
        $short = mb_substr($this->postText, 0, 80);

        return $short;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getCommentsPost(): Collection
    {
        return $this->CommentsPost;
    }

    public function addCommentsPost(Comments $commentsPost): self
    {
        if (!$this->CommentsPost->contains($commentsPost)) {
            $this->CommentsPost[] = $commentsPost;
            $commentsPost->setContent($this);
        }

        return $this;
    }

    public function removeCommentsPost(Comments $commentPost): self
    {
        if ($this->CommentsPost->contains($commentPost)) {
            $this->CommentsPost->removeElement($commentPost);
            // set the owning side to null (unless already changed)
            if ($commentPost->getContent() === $this) {
                $commentPost->setContent(null);
            }
        }

        return $this;
    }
}
