<?php

namespace Killboard\V1\Rest\Agent;

use DoctrineModule\Stdlib\Hydrator\Filter\PropertyName;

class AgentFilterFactory
{
    public function __invoke($container)
    {
        $mvcEvent = $container->get('Application')->getMvcEvent();
        $routeName = $mvcEvent->getRouteMatch()->getMatchedRouteName();

        if ($routeName === 'killboard.rest.doctrine.kill') {
            return new PropertyName([
                'id',
                'name',
            ], false);
        }

        return new PropertyName([
            'uid'
        ], true);
    }
}

