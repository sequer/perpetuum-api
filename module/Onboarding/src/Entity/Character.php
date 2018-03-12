<?php

namespace Onboarding\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="dbo.characters")
 */
class Character
{
    /**
     * @ORM\Id
     * @ORM\Column(name="characterID", type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="characters")
     * @ORM\JoinColumn(name="accountID", referencedColumnName="accountID")
     */
    protected $account;

    /**
     * @ORM\Column(name="nick", type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $createdOn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }
}
