<?php

	namespace App\Entity;

	use DateTime;
	use DateTimeInterface;
	use Doctrine\ORM\Mapping as ORM;
	use Exception;

	/**
	 * @ORM\Entity(repositoryClass="App\Repository\ApiTokenRepository")
	 */
	class ApiToken
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
		private $token;

		/**
		 * @ORM\Column(type="datetime")
		 */
		private $expiresAt;

		/**
		 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="apiTokens")
		 * @ORM\JoinColumn(nullable=false)
		 */
		private $user;

		/**
		 * ApiToken constructor.
		 * @param User $user
		 * @throws Exception
		 */
		public function __construct(User $user)
		{
			$this->token = bin2hex(random_bytes(60));
			$this->user = $user;
			$this->expiresAt = new DateTime('+1 hour');
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
		public function getToken(): ?string
		{
			return $this->token;
		}

		/**
		 * @param string $token
		 * @return ApiToken
		 */
		public function setToken(string $token): self
		{
			$this->token = $token;

			return $this;
		}

		/**
		 * @return DateTimeInterface|null
		 */
		public function getExpiresAt(): ?DateTimeInterface
		{
			return $this->expiresAt;
		}

		/**
		 * @param DateTimeInterface $expiresAt
		 * @return ApiToken
		 */
		public function setExpiresAt(DateTimeInterface $expiresAt): self
		{
			$this->expiresAt = $expiresAt;

			return $this;
		}

		/**
		 * @return User|null
		 */
		public function getUser(): ?User
		{
			return $this->user;
		}

		/**
		 * @param User|null $user
		 * @return ApiToken
		 */
		public function setUser(?User $user): self
		{
			$this->user = $user;

			return $this;
		}

		/**
		 *
		 */
		public function isExpired()
		{
			return $this->getExpiresAt() <= (new DateTime());
		}
	}
