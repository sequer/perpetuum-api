<?php

namespace Killboard\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 */
class Agent extends Entity
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $uid;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Killboard\Entity\Corporation", inversedBy="agents")
     * @ORM\JoinColumn(name="corporationId", referencedColumnName="id")
     */
    private $corporation;

    /**
     * @ORM\OneToMany(targetEntity="Killboard\Entity\Kill", mappedBy="agent")
     */
    private $deaths;

    /**
     * @ORM\OneToMany(targetEntity="Killboard\Entity\Attacker", mappedBy="agent")
     */
    private $kills;

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCorporation(Corporation $corporation)
    {
        $this->corporation = $corporation;
    }

    public function getCorporation()
    {
        return $this->corporation;
    }
}
