<?php

namespace Killboard\V1\Rest\Attacker;

use DoctrineModule\Stdlib\Hydrator\Filter\PropertyName;

class AttackerFilterFactory
{
    public function __invoke($container)
    {
        $mvcEvent = $container->get('Application')->getMvcEvent();
        $routeName = $mvcEvent->getRouteMatch()->getMatchedRouteName();

        if ($routeName === 'killboard.rest.doctrine.kill') {
            return new PropertyName([
                'kill',
            ], true);
        }

        return new PropertyName([
            'id',
        ], false);
    }
}

