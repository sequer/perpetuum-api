<?php

namespace Onboarding\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="dbo.accounts")
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\Column(name="accountID", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="account")
     */
    protected $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
