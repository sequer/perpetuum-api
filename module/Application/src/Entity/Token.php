<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"email_confirmation" = "EmailConfirmation", "password_reset" = "PasswordReset"})
 */
abstract class Token extends Entity
{
    /**
     * @ORM\Column(type="string")
     */
    protected $hash;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdOn;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $consumedOn;

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function setConsumedOn($consumedOn)
    {
        $this->consumedOn = $consumedOn;
    }

    public function getConsumedOn()
    {
        return $this->consumedOn;
    }
}
