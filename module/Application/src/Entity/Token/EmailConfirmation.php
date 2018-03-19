<?php

namespace Application\Entity\Token;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EmailConfirmation extends Token
{
    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
