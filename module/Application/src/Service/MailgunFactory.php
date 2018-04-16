<?php

namespace Application\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Mailgun\Mailgun;
use Zend\Config\Config;

class MailgunFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = new Config($container->get('Config'));

        $mailgun = Mailgun::create($config->mailgun->key);

        return $mailgun;
    }
}

