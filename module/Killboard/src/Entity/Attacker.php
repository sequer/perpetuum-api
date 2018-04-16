<?php

namespace Killboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Attacker extends Entity
{
    /**
     * @ORM\Column(type="decimal", precision=16, scale=4)
     */
    private $damageDealt = 0.0000;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasKillingBlow = false;

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

    public function setHasKillingBlow($hasKillingBlow)
    {
        $this->hasKillingBlow = $hasKillingBlow;
    }

    public function getHasKillingBlow()
    {
        return $this->hasKillingBlow;
    }

    public function setTotalEcmAttempts($totalEcmAttempts)
    {
        $this->totalEcmAttempts = $totalEcmAttempts;
    }

    public function getTotalEcmAttempts()
    {
        return $this->totalEcmAttempts;
    }

    public function setSuccessfullEcmAttempts($successfulEcmAttempts)
    {
        $this->successfulEcmAttempts = $successfulEcmAttempts;
    }

    public function getSuccessfullEcmAttempts()
    {
        return $this->successfulEcmAttempts;
    }

    public function setDemobilisations($demobilisations)
    {
        $this->demobilisations = $demobilisations;
    }

    public function getDemobilisation()
    {
        return $this->demobilisations;
    }

    public function setSensorSuppressions($sensorSuppressions)
    {
        return $this->sensorSuppressions;
    }

    public function getSensorSuppressions()
    {
        return $this->sensorSuppressions;
    }

    public function setEnergyDispersed($energyDispersed)
    {
        $this->energyDispersed = $energyDispersed;
    }

    public function getEnergyDispersed()
    {
        return $this->energyDispersed;
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
