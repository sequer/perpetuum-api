<?php

namespace Killboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Attacker extends Entity
{
    /**
     * @ORM\Column(type="integer")
     */
    private $totalEcmAttempts = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $successfulEcmAttempts = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $demobilisations = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $sensorSuppressions = 0;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=4)
     */
    private $energyDispersed = 0.0000;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=4)
     */
    private $damageDealt = 0.0000;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasKillingBlow = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasMostDamage = false;

    /**
     * @ORM\ManyToOne(targetEntity="Kill", inversedBy="attackers")
     * @ORM\JoinColumn(name="killId", referencedColumnName="id")
     */
    private $kill;

    /**
     * @ORM\ManyToOne(targetEntity="Agent", inversedBy="kills")
     * @ORM\JoinColumn(name="agentId", referencedColumnName="id")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="Corporation", inversedBy="kills")
     * @ORM\JoinColumn(name="corporationId", referencedColumnName="id")
     */
    private $corporation;

    /**
     * @ORM\ManyToOne(targetEntity="Robot", inversedBy="kills")
     * @ORM\JoinColumn(name="robotId", referencedColumnName="id")
     */
    private $robot;

    public function setDamageDealt($damageDealt)
    {
        $this->damageDealt = $damageDealt;
    }

    public function getDamageDealt()
    {
        return $this->damageDealt;
    }



    public function setKill(Kill $kill)
    {
        $this->kill = $kill;
    }

    public function getKill()
    {
        return $this->kill;
    }

    public function setAgent(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function getAgent()
    {
        return $this->agent;
    }

    public function setCorporation(Corporation $corporation)
    {
        $this->corporation = $corporation;
    }

    public function getCorporation()
    {
        return $this->corporation;
    }

    public function setRobot(Robot $robot)
    {
        $this->robot = $robot;
    }

    public function getRobot()
    {
        return $this->robot;
    }
}
