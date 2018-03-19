<?php
namespace Onboarding\V1\Rpc\Register;

class RegisterControllerFactory
{
    public function __invoke($container)
    {
        return new RegisterController(
            $container->get('doctrine.entitymanager.orm_default'),
            $container->get('doctrine.entitymanager.orm_sqlsrv')
        );
    }
}
