<?php
namespace Onboarding\V1\Rpc\ResetWithToken;

class ResetWithTokenControllerFactory
{
    public function __invoke($container)
    {
        return new ResetWithTokenController(
            $container->get('doctrine.entitymanager.orm_default'),
            $container->get('doctrine.entitymanager.orm_sqlsrv')
        );
    }
}
