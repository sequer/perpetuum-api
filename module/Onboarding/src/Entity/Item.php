<?php

namespace Onboarding\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="entitydefaults", schema="dbo")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(name="definition", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="definitionname", type="string")
     */
    protected $name;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
