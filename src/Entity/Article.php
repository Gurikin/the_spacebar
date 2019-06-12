<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $title;

  /**
   * @ORM\Column(type="string", length=100, unique=true)
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
   * @ORM\Column(type="string", length=255)
   */
  private $author;

  /**
   * @ORM\Column(type="integer")
   */
  private $heartCount = 0;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $imageFilename;

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
   * @return string|null
   */
  public function getAuthor(): ?string
  {
    return $this->author;
  }

  /**
   * @param string $author
   * @return Article
   */
  public function setAuthor(string $author): self
  {
    $this->author = $author;

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
}
