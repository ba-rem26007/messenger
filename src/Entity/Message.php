<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    const CHOICES = [
        'Slack' => 'slack',
        'Email' => 'email',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $emissionDate;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sendingDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $choice;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getEmissionDate(): ?\DateTimeInterface
    {
        return $this->emissionDate;
    }

    public function setEmissionDate(?\DateTimeInterface $emissionDate): self
    {
        $this->emissionDate = $emissionDate;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSendingDate(): ?\DateTimeInterface
    {
        return $this->sendingDate;
    }

    public function setSendingDate(?\DateTimeInterface $sendingDate): self
    {
        $this->sendingDate = $sendingDate;

        return $this;
    }

    public function getChoice(): ?string
    {
        return $this->choice;
    }

    public function setChoice(string $choice): self
    {
        $this->choice = $choice;

        return $this;
    }



}
