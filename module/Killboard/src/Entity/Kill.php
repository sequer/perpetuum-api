<?php

namespace Killboard\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="`Kill`")
 */
class Kill extends Entity
{
    /**
     * @ORM\Column(type="string")
     */
    private $uid;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=4)
     */
    private $damageReceived = '0.0000';

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Agent", inversedBy="deaths")
     * @ORM\JoinColumn(name="agentId", referencedColumnName="id")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity="Corporation", inversedBy="deaths")
     * @ORM\JoinColumn(name="corporationId", referencedColumnName="id")
     */
    private $corporation;

    /**
     * @ORM\ManyToOne(targetEntity="Robot", inversedBy="deaths")
     * @ORM\JoinColumn(name="robotId", referencedColumnName="id")
     */
    private $robot;

    /**
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="deaths")
     * @ORM\JoinColumn(name="zoneId", referencedColumnName="id")
     */
    private $zone;

    /**
     * @ORM\OneToMany(targetEntity="Attacker", mappedBy="kill")
     */
    private $attackers;

    public function __construct()
    {
        $this->attackers = new ArrayCollection();
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setDamageReceived($damageReceived)
    {
        $this->damageReceived = $damageReceived;
    }

    public function getDamageReceived()
    {
        return $this->damageReceived;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
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

    public function setZone(Zone $zone)
    {
        $this->zone = $zone;
    }

    public function getZone()
    {
        return $this->zone;
    }

    public function addAttacker(Attacker $attacker)
    {
        $this->attackers[] = $attacker;
    }

    public function removeAttacker(Attacker $attacker)
    {
        $this->attackers->removeElement($attacker);
    }

    public function getAttackers()
    {
        return $this->attackers;
    }
}
