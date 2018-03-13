<?php
namespace Onboarding;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'doctrine.connection.orm_sqlsrv' => new \DoctrineORMModule\Service\DBALConnectionFactory('orm_sqlsrv'),
                'doctrine.configuration.orm_sqlsrv' => new \DoctrineORMModule\Service\ConfigurationFactory('orm_sqlsrv'),
                'doctrine.entitymanager.orm_sqlsrv' => new \DoctrineORMModule\Service\EntityManagerFactory('orm_sqlsrv'),
                'doctrine.driver.orm_sqlsrv' => new \DoctrineModule\Service\DriverFactory('orm_sqlsrv'),
                'doctrine.eventmanager.orm_sqlsrv' => new \DoctrineModule\Service\EventManagerFactory('orm_sqlsrv'),
                'doctrine.entity_resolver.orm_sqlsrv' => new \DoctrineORMModule\Service\EntityResolverFactory('orm_sqlsrv'),
            ],
        ];
    }
}
