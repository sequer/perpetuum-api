<?php

return [
    'doctrine' => [
        'entitymanager' => [
            'orm_default' => [
                'connection'    => 'orm_default',
                'configuration' => 'orm_default'
            ],
            'orm_sqlsrv' => [
                'connection'    => 'orm_sqlsrv',
                'configuration' => 'orm_sqlsrv'
            ]
        ],
       'configuration' => [
            'orm_sqlsrv' => [
                'metadata_cache'    => 'array',
                'query_cache'       => 'array',
                'result_cache'      => 'array',
                'driver'            => 'orm_sqlsrv',
                'generate_proxies'  => true,
                'proxy_dir'         => 'data/DoctrineORMModule/Proxy',
                'proxy_namespace'   => 'DoctrineORMModule\Proxy',
                'filters'           => [],
                'types'             => [
                    'datetime' => \Application\Doctrine\Type\DateTimeType::class,
                ],
            ],
        ],
        'driver' => [
            'orm_default_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../../module/Application/src/Entity',
                    __DIR__.'/../../module/Killboard/src/Entity',
                ],
            ],
            'orm_sqlsrv_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../../module/Onboarding/src/Entity'
                ],
            ],
            'orm_default' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => [
                    'Application\Entity' => 'orm_default_driver',
                    'Killboard\Entity' => 'orm_default_driver'
                ]
            ],
            'orm_sqlsrv' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => [
                    'Onboarding\Entity' => 'orm_sqlsrv_driver'
                ]
            ],
        ]
    ],
];
