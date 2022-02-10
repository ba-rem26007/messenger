<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
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
    private $Title;

    /**
     * @ORM\Column(type="text")
     */
    private $Body;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $EmissionDate;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private $Status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $SendingDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Choice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->Body;
    }

    public function setBody(string $Body): self
    {
        $this->Body = $Body;

        return $this;
    }

    public function getEmissionDate(): ?\DateTimeInterface
    {
        return $this->EmissionDate;
    }

    public function setEmissionDate(?\DateTimeInterface $EmissionDate): self
    {
        $this->EmissionDate = $EmissionDate;

        return $this;
    }

    public function getStatus(): ?bool
    {
        //if($this->Status=="")$this->Status=0;
        return $this->Status;
    }

    public function setStatus(bool $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getSendingDate(): ?\DateTimeInterface
    {
        return $this->SendingDate;
    }

    public function setSendingDate(?\DateTimeInterface $SendingDate): self
    {
        $this->SendingDate = $SendingDate;

        return $this;
    }

    public function getChoice(): ?string
    {
        return $this->Choice;
    }

    public function setChoice(string $Choice): self
    {
        $this->Choice = $Choice;

        return $this;
    }
}
