<?php
namespace Onboarding\V1\Rpc\Verify;

class VerifyControllerFactory
{
    public function __invoke($container)
    {
        return new VerifyController(
        	$container->get('doctrine.entitymanager.orm_default'),
        	$container->get('doctrine.entitymanager.orm_sqlsrv')
        );
    }
}
