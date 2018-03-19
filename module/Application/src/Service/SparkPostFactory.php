<?php

namespace Application\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = new Config($container->get('Config'));

        $httpClient = new GuzzleAdapter(new Client());
        $sparkPost = new SparkPost(
            $httpClient,
            [
                'key' => $config->sparkpost->key,
                'async' => false,
            ]
        );

        return $sparkPost;
    }
}

