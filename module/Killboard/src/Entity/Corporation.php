<?php

namespace Killboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Corporation extends Entity
{
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Killboard\Entity\Kill", mappedBy="corporation")
     */
    private $deaths;

    /**
     * @ORM\OneToMany(targetEntity="Killboard\Entity\Attacker", mappedBy="corporation")
     */
    private $kills;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
