<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Account extends Entity
{
    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * Store SHA1 hashes, because the Perpetuum server does too.
     *
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdOn;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    protected $hasEmailConfirmed = false;

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function setHasEmailConfirmed($hasEmailConfirmed)
    {
        $this->hasEmailConfirmed = $hasEmailConfirmed;
    }

    public function getHasEmailConfirmed(): bool
    {
        return $this->hasEmailConfirmed;
    }

    public function hasEmailConfirmed(): bool
    {
        return $this->getHasEmailConfirmed();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->setCreatedOn(new DateTime('now'));
    }
}
