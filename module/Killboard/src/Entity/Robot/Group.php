<?php

namespace Killboard\Entity\Robot;

use Doctrine\ORM\Mapping as ORM;
use Killboard\Entity\Entity;

/**
 * @ORM\Entity
 */
class Group extends Entity
{
    private $name;

    private $robots;
}
