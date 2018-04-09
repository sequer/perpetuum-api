<?php
return [
    'router' => [
        'routes' => [
            'onboarding.rest.doctrine.account' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/onboarding/account[/:account_id]',
                    'defaults' => [
                        'controller' => 'Onboarding\\V1\\Rest\\Account\\Controller',
                    ],
                ],
            ],
            'onboarding.rest.doctrine.character' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/onboarding/character[/:character_id]',
                    'defaults' => [
                        'controller' => 'Onboarding\\V1\\Rest\\Character\\Controller',
                    ],
                ],
            ],
            'onboarding.rpc.register' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/onboarding/register',
                    'defaults' => [
                        'controller' => 'Onboarding\\V1\\Rpc\\Register\\Controller',
                        'action' => 'register',
                    ],
                ],
            ],
            'onboarding.rpc.verify' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/onboarding/verify/:token',
                    'defaults' => [
                        'controller' => 'Onboarding\\V1\\Rpc\\Verify\\Controller',
                        'action' => 'verify',
                    ],
                ],
            ],
            'onboarding.rpc.reset' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/onboarding/reset[/:token]',
                    'defaults' => [
                        'controller' => 'Onboarding\\V1\\Rpc\\Reset\\Controller',
                        'action' => 'reset',
                    ],
                ],
            ],
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'find' => [
                    'type' => 'simple',
                    'options' => [
                        'route' => 'find',
                        'defaults' => [
                            'controller' => \Onboarding\Controller\ConsoleController::class,
                            'action' => 'find',
                        ],
                    ],
                ],
                'sync' => [
                    'type' => 'simple',
                    'options' => [
                        'route' => 'sync',
                        'defaults' => [
                            'controller' => \Onboarding\Controller\ConsoleController::class,
                            'action' => 'sync',
                        ],
                    ],
                ],
                'kill' => [
                    'type' => 'simple',
                    'options' => [
                        'route' => 'kill',
                        'defaults' => [
                            'controller' => \Onboarding\Controller\ConsoleController::class,
                            'action' => 'kill',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'validators' => [
        'factories' => [
            \Onboarding\Validator\NoObjectExists::class => \Onboarding\Validator\NoObjectExistsFactory::class,
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'onboarding.rest.doctrine.account',
            1 => 'onboarding.rest.doctrine.character',
            2 => 'onboarding.rpc.register',
            3 => 'onboarding.rpc.verify',
            4 => 'onboarding.rpc.reset',
        ],
    ],
    'zf-rest' => [
        'Onboarding\\V1\\Rest\\Account\\Controller' => [
            'listener' => \Onboarding\V1\Rest\Account\AccountResource::class,
            'route_name' => 'onboarding.rest.doctrine.account',
            'route_identifier_name' => 'account_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'account',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Onboarding\Entity\Account::class,
            'collection_class' => \Onboarding\V1\Rest\Account\AccountCollection::class,
            'service_name' => 'Account',
        ],
        'Onboarding\\V1\\Rest\\Character\\Controller' => [
            'listener' => \Onboarding\V1\Rest\Character\CharacterResource::class,
            'route_name' => 'onboarding.rest.doctrine.character',
            'route_identifier_name' => 'character_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'character',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Onboarding\Entity\Character::class,
            'collection_class' => \Onboarding\V1\Rest\Character\CharacterCollection::class,
            'service_name' => 'Character',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Onboarding\\V1\\Rest\\Account\\Controller' => 'HalJson',
            'Onboarding\\V1\\Rest\\Character\\Controller' => 'HalJson',
            'Onboarding\\V1\\Rpc\\Register\\Controller' => 'Json',
            'Onboarding\\V1\\Rpc\\Verify\\Controller' => 'Json',
            'Onboarding\\V1\\Rpc\\Reset\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'Onboarding\\V1\\Rest\\Account\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Onboarding\\V1\\Rest\\Character\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Onboarding\\V1\\Rpc\\Register\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'Onboarding\\V1\\Rpc\\Verify\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'Onboarding\\V1\\Rpc\\Reset\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'Onboarding\\V1\\Rest\\Account\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
            ],
            'Onboarding\\V1\\Rest\\Character\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
            ],
            'Onboarding\\V1\\Rpc\\Register\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
            ],
            'Onboarding\\V1\\Rpc\\Verify\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
            ],
            'Onboarding\\V1\\Rpc\\Reset\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Onboarding\Entity\Account::class => [
                'route_identifier_name' => 'account_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'onboarding.rest.doctrine.account',
                'hydrator' => 'Onboarding\\V1\\Rest\\Account\\AccountHydrator',
            ],
            \Onboarding\V1\Rest\Account\AccountCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'onboarding.rest.doctrine.account',
                'is_collection' => true,
            ],
            \Onboarding\Entity\Character::class => [
                'route_identifier_name' => 'character_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'onboarding.rest.doctrine.character',
                'hydrator' => 'Onboarding\\V1\\Rest\\Character\\CharacterHydrator',
            ],
            \Onboarding\V1\Rest\Character\CharacterCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'onboarding.rest.doctrine.character',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-apigility' => [
        'doctrine-connected' => [
            \Onboarding\V1\Rest\Account\AccountResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_sqlsrv',
                'hydrator' => 'Onboarding\\V1\\Rest\\Account\\AccountHydrator',
            ],
            \Onboarding\V1\Rest\Character\CharacterResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_sqlsrv',
                'hydrator' => 'Onboarding\\V1\\Rest\\Character\\CharacterHydrator',
            ],
        ],
    ],
    'doctrine-hydrator' => [
        'Onboarding\\V1\\Rest\\Account\\AccountHydrator' => [
            'entity_class' => \Onboarding\Entity\Account::class,
            'object_manager' => 'doctrine.entitymanager.orm_sqlsrv',
            'by_value' => false,
            'strategies' => [
                'characters' => \ZF\Doctrine\Hydrator\Strategy\CollectionExtract::class,
            ],
            'use_generated_hydrator' => true,
        ],
        'Onboarding\\V1\\Rest\\Character\\CharacterHydrator' => [
            'entity_class' => \Onboarding\Entity\Character::class,
            'object_manager' => 'doctrine.entitymanager.orm_sqlsrv',
            'by_value' => false,
            'strategies' => [
                'account' => \ZF\Doctrine\Hydrator\Strategy\EntityLink::class,
            ],
            'use_generated_hydrator' => true,
        ],
    ],
    'zf-content-validation' => [
        'Onboarding\\V1\\Rest\\Account\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rest\\Account\\Validator',
        ],
        'Onboarding\\V1\\Rest\\Character\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rest\\Character\\Validator',
        ],
        'Onboarding\\V1\\Rpc\\Register\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rpc\\Register\\Validator',
        ],
        'Onboarding\\V1\\Rpc\\Verify\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rpc\\Verify\\Validator',
        ],
        'Onboarding\\V1\\Rpc\\Reset\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rpc\\Reset\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Onboarding\\V1\\Rest\\Account\\Validator' => [
            0 => [
                'name' => 'email',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [],
            ],
        ],
        'Onboarding\\V1\\Rest\\Character\\Validator' => [
            0 => [
                'name' => 'account',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [],
            ],
            1 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [],
            ],
            2 => [
                'name' => 'createdOn',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'Onboarding\\V1\\Rpc\\Register\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Onboarding\Validator\NoObjectExists::class,
                        'options' => [
                            'object_repository' => \Onboarding\Entity\Account::class,
                            'object_manager' => 'doctrine.entitymanager.orm_sqlsrv',
                            'fields' => [
                                0 => 'email',
                            ],
                        ],
                    ],
                    2 => [
                        'name' => \Onboarding\Validator\NoObjectExists::class,
                        'options' => [
                            'object_repository' => \Application\Entity\Account::class,
                            'object_manager' => 'doctrine.entitymanager.orm_default',
                            'fields' => [
                                0 => 'email',
                            ],
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'email',
                'description' => 'The email address.',
            ],
            1 => [
                'name' => 'password',
                'description' => 'The password.',
                'required' => true,
            ],
        ],
        'Onboarding\\V1\\Rpc\\Verify\\Validator' => [],
        'Onboarding\\V1\\Rpc\\Reset\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'password',
                'description' => 'The password.',
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Onboarding\\V1\\Rpc\\Register\\Controller' => \Onboarding\V1\Rpc\Register\RegisterControllerFactory::class,
            'Onboarding\\V1\\Rpc\\Verify\\Controller' => \Onboarding\V1\Rpc\Verify\VerifyControllerFactory::class,
            'Onboarding\\V1\\Rpc\\Reset\\Controller' => \Onboarding\V1\Rpc\Reset\ResetControllerFactory::class,
            \Onboarding\Controller\ConsoleController::class => \Onboarding\Controller\ConsoleControllerFactory::class,
        ],
    ],
    'zf-rpc' => [
        'Onboarding\\V1\\Rpc\\Register\\Controller' => [
            'service_name' => 'register',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'onboarding.rpc.register',
        ],
        'Onboarding\\V1\\Rpc\\Verify\\Controller' => [
            'service_name' => 'verify',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'onboarding.rpc.verify',
        ],
        'Onboarding\\V1\\Rpc\\Reset\\Controller' => [
            'service_name' => 'reset',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'onboarding.rpc.reset',
        ],
    ],
];
