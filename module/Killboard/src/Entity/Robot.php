<?php

namespace Killboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Robot extends Entity
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $definition;

    /**
     * @ORM\ManyToOne(targetEntity="Killboard\Entity\Robot\Group", inversedBy="robots")
     * @ORM\JoinColumn(name="groupId", referencedColumnName="id")
     */
    private $group;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDefinition($definition)
    {
        $this->definition = $definition;
    }

    public function getDefinition()
    {
        return $this->definition;
    }
}
