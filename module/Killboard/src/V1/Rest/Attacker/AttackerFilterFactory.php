<?php

namespace Killboard\V1\Rest\Attacker;

use DoctrineModule\Stdlib\Hydrator\Filter\PropertyName;

class AttackerFilterFactory
{
    public function __invoke($container)
    {
        return new PropertyName([
            'id',
        ], false);
    }
}

