<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
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
	 */
	private $name;

	/**
	 * @Gedmo\Slug(fields={"name"})
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	private $slug;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="tags")
	 */
	private $articles;

	public function __construct()
	{
		$this->articles = new ArrayCollection();
	}

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

	public function getSlug(): ?string
	{
		return $this->slug;
	}

	public function setSlug(string $slug): self
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * @return Collection|Article[]
	 */
	public function getArticles(): Collection
	{
		return $this->articles;
	}

	public function addArticle(Article $article): self
	{
		if (!$this->articles->contains($article)) {
			$this->articles[] = $article;
		}

		return $this;
	}

	public function removeArticle(Article $article): self
	{
		if ($this->articles->contains($article)) {
			$this->articles->removeElement($article);
		}

		return $this;
	}
}
