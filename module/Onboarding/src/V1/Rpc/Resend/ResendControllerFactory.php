<?php

namespace Onboarding\V1\Rpc\Resend;

use Application\Service\Mailer;

class ResendControllerFactory
{
    public function __invoke($container)
    {
        return new ResendController(
            $container->get('doctrine.entitymanager.orm_default'),
            $container->get(Mailer::class)
        );
    }
}
