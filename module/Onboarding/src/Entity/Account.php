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
    const LEAD_SOURCE_API = 'webapiregister';
    const LEAD_SOURCE_GAME = 'opencreate';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="accountID", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    /**
     * @ORM\Column(name="password", type="string")
     */
    protected $password;

    /**
     * @ORM\Column(name="emailConfirmed", type="boolean")
     */
    protected $hasEmailConfirmed;

    /**
     * @ORM\Column(name="campaignid", type="json_array")
     */
    protected $leadSource;

    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="account")
     */
    protected $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

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

    public function setHasEmailConfirmed($hasEmailConfirmed)
    {
        $this->hasEmailConfirmed = $hasEmailConfirmed;
    }

    public function getHasEmailConfirmed()
    {
        return $this->hasConfirmedEmail;
    }

    public function setLeadSource($leadSource)
    {
        $this->leadSource = $leadSource;
    }

    public function getLeadSource()
    {
        return $this->leadSource;
    }
}
