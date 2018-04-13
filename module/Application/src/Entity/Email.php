<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 */
class Email extends Entity
{
    const NAME_SITE_REGISTER_VERIFY = 'site-register-verify';
    const NAME_SERVER_REGISTER_VERIFY = 'server-register-verify';
    const NAME_SITE_PASSWORD_RESET = 'site-password-reset';

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $sentOn;

    /**
     * @ORM\ManyToOne(targetEntity="Token")
     * @ORM\JoinColumn(name="tokenId", referencedColumnName="id")
     */
    protected $token;

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSentOn($sentOn)
    {
        $this->sentOn = $sentOn;
    }

    public function getSentOn()
    {
        return $this->sentOn;
    }

    public function setToken(Token $token)
    {
        $this->token = $token;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }
}
