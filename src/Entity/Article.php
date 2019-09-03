<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
	use TimestampableEntity;
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank(message="Get creative and think of a title!")
	 */
	private $title;

	/**
	 * @Gedmo\Slug(fields={"title"})
	 * @ORM\Column(type="string", length=128, unique=true)
	 */
	private $slug;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $content;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $publishedAt;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $heartCount = 0;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $imageFilename;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article", fetch="EXTRA_LAZY")
	 * @ORM\OrderBy({"createdAt" = "DESC"})
	 */
	private $comments;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="articles")
	 */
	private $tags;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotNull(message="Please set an author")
	 */
	private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specific_location_name;

	/**
	 * Article constructor.
	 */
	public function __construct()
                  	{
                  		$this->comments = new ArrayCollection();
                  		$this->tags = new ArrayCollection();
                  	}

	/**
	 * @return int|null
	 */
	public function getId(): ?int
                  	{
                  		return $this->id;
                  	}

	/**
	 * @return string|null
	 */
	public function getTitle(): ?string
                  	{
                  		return $this->title;
                  	}

	/**
	 * @param string $title
	 * @return Article
	 */
	public function setTitle(string $title): self
                  	{
                  		$this->title = $title;
                  
                  		return $this;
                  	}

	/**
	 * @return string|null
	 */
	public function getSlug(): ?string
                  	{
                  		return $this->slug;
                  	}

	/**
	 * @param string $slug
	 * @return Article
	 */
	public function setSlug(string $slug): self
                  	{
                  		$this->slug = $slug;
                  
                  		return $this;
                  	}

	/**
	 * @return string|null
	 */
	public function getContent(): ?string
                  	{
                  		return $this->content;
                  	}

	/**
	 * @param string|null $content
	 * @return Article
	 */
	public function setContent(?string $content): self
                  	{
                  		$this->content = $content;
                  
                  		return $this;
                  	}

	/**
	 * @return DateTimeInterface|null
	 */
	public function getPublishedAt(): ?DateTimeInterface
                  	{
                  		return $this->publishedAt;
                  	}

	/**
	 * @param DateTimeInterface|null $publishedAt
	 * @return Article
	 */
	public function setPublishedAt(?DateTimeInterface $publishedAt): self
                  	{
                  		$this->publishedAt = $publishedAt;
                  
                  		return $this;
                  	}

	/**
	 * @return int|null
	 */
	public function getHeartCount(): ?int
                  	{
                  		return $this->heartCount;
                  	}

	/**
	 * @param int $heartCount
	 * @return Article
	 */
	public function setHeartCount(int $heartCount): self
                  	{
                  		$this->heartCount = $heartCount;
                  
                  		return $this;
                  	}

	/**
	 * @return string|null
	 */
	public function getImageFilename(): ?string
                  	{
                  		return $this->imageFilename;
                  	}

	/**
	 * @param string|null $imageFilename
	 * @return Article
	 */
	public function setImageFilename(?string $imageFilename): self
                  	{
                  		$this->imageFilename = $imageFilename;
                  
                  		return $this;
                  	}

	/**
	 * @return Article
	 */
	public function incrementHeartCount(): self
                  	{
                  		$heartCount = $this->getHeartCount() + 1;
                  		$this->setHeartCount($heartCount);
                  		return $this;
                  	}

	/**
	 * @return Collection
	 */
	public function getComments(): Collection
                  	{
                  		return $this->comments;
                  	}

	/**
	 * @return Collection
	 */
	public function getNonDeletedComments(): Collection
                  	{
                  		$criteria = CommentRepository::createNonDeletedCriteria();
                  		return $this->comments->matching($criteria);
                  	}

	/**
	 * @param Comment $comment
	 * @return Article
	 */
	public function addComment(Comment $comment): self
                  	{
                  		if (!$this->comments->contains($comment)) {
                  			$this->comments[] = $comment;
                  			$comment->setArticle($this);
                  		}
                  
                  		return $this;
                  	}

	/**
	 * @param Comment $comment
	 * @return Article
	 */
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

	/**
	 * @return Collection|Tag[]
	 */
	public function getTags(): Collection
                  	{
                  		return $this->tags;
                  	}

	/**
	 * @param Tag $tag
	 * @return Article
	 */
	public function addTag(Tag $tag): self
                  	{
                  		if (!$this->tags->contains($tag)) {
                  			$this->tags[] = $tag;
                  			$tag->addArticle($this);
                  		}
                  
                  		return $this;
                  	}

	/**
	 * @param Tag $tag
	 * @return Article
	 */
	public function removeTag(Tag $tag): self
                  	{
                  		if ($this->tags->contains($tag)) {
                  			$this->tags->removeElement($tag);
                  			$tag->removeArticle($this);
                  		}
                  
                  		return $this;
                  	}

	/**
	 * @return User|null
	 */
	public function getAuthor(): ?User
                  	{
                  		return $this->author;
                  	}

	/**
	 * @param User|null $author
	 * @return Article
	 */
	public function setAuthor(?User $author): self
                  	{
                  		$this->author = $author;
                  
                  		return $this;
                  	}

	/**
	 * @return bool
	 * @throws Exception
	 */
	public function isPublished(): bool
                  	{
                  		$isPublished = ($this->getPublishedAt() !== null) && ($this->getPublishedAt() <= (new DateTime('now')));
                  		return $isPublished;
                  	}

	/**
	 * @Assert\Callback
	 * @param ExecutionContextInterface $context
	 * @param $payload
	 */
	public function validate(ExecutionContextInterface $context, $payload)
                  	{
                  		if ($this->getTitle() == $this->getContent()) {
                  			$context->buildViolation('Будь креативным и оригинальным')
                  				->atPath('title')
                  				->addViolation();
                  			$context->buildViolation('Будь креативным и оригинальным')
                  				->atPath('content')
                  				->addViolation();
                  		}
                  	}

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        if (!$this->location || $this->location === 'interstellar_space') {
            $this->setSpecificLocationName(null);
        }

        return $this;
    }

    public function getSpecificLocationName(): ?string
    {
        return $this->specific_location_name;
    }

    public function setSpecificLocationName(?string $specific_location_name): self
    {
        $this->specific_location_name = $specific_location_name;

        return $this;
    }
}
