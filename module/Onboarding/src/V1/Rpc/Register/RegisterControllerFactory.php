<?php
namespace Onboarding\V1\Rpc\Register;

use Application\Service\Mailer;

class RegisterControllerFactory
{
    public function __invoke($container)
    {
        return new RegisterController(
            $container->get('doctrine.entitymanager.orm_default'),
            $container->get(Mailer::class)
        );
    }
}
