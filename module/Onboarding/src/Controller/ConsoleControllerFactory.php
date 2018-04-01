<?php
namespace Onboarding\Controller;

use Application\Service\Mailer;

class ConsoleControllerFactory
{
    public function __invoke($container)
    {
        return new ConsoleController(
            $container->get('doctrine.entitymanager.orm_default'),
            $container->get('doctrine.entitymanager.orm_sqlsrv'),
            $container->get(Mailer::class);
        );
    }
}
