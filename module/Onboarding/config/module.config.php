<?php
return [
    'router' => [
        'routes' => [
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
                    'route' => '/onboarding/reset',
                    'defaults' => [
                        'controller' => 'Onboarding\\V1\\Rpc\\Reset\\Controller',
                        'action' => 'reset',
                    ],
                ],
            ],
            'onboarding.rpc.resend' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/onboarding/resend',
                    'defaults' => [
                        'controller' => 'Onboarding\\V1\\Rpc\\Resend\\Controller',
                        'action' => 'resend',
                    ],
                ],
            ],
            'onboarding.rpc.reset-with-token' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/onboarding/reset/:token',
                    'defaults' => [
                        'controller' => 'Onboarding\\V1\\Rpc\\ResetWithToken\\Controller',
                        'action' => 'resetWithToken',
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
                'translate' => [
                    'type' => 'simple',
                    'options' => [
                        'route' => 'translate',
                        'defaults' => [
                            'controller' => \Onboarding\Controller\ConsoleController::class,
                            'action' => 'translate',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'validators' => [
        'factories' => [
            \Onboarding\Validator\NoObjectExists::class => \Onboarding\Validator\NoObjectExistsFactory::class,
            \Onboarding\Validator\ObjectExists::class => \Onboarding\Validator\ObjectExistsFactory::class,
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            2 => 'onboarding.rpc.register',
            3 => 'onboarding.rpc.verify',
            4 => 'onboarding.rpc.reset',
            5 => 'onboarding.rpc.resend',
            6 => 'onboarding.rpc.reset-with-token',
        ],
    ],
    'zf-rest' => [
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Onboarding\\V1\\Rpc\\Register\\Controller' => 'Json',
            'Onboarding\\V1\\Rpc\\Verify\\Controller' => 'Json',
            'Onboarding\\V1\\Rpc\\Reset\\Controller' => 'Json',
            'Onboarding\\V1\\Rpc\\Resend\\Controller' => 'Json',
            'Onboarding\\V1\\Rpc\\ResetWithToken\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
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
            'Onboarding\\V1\\Rpc\\Resend\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'Onboarding\\V1\\Rpc\\ResetWithToken\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
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
            'Onboarding\\V1\\Rpc\\Resend\\Controller' => [
                0 => 'application/vnd.onboarding.v1+json',
                1 => 'application/json',
            ],
            'Onboarding\\V1\\Rpc\\ResetWithToken\\Controller' => [
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
        ],
    ],
    'doctrine-hydrator' => [
    ],
    'zf-content-validation' => [
        'Onboarding\\V1\\Rpc\\Register\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rpc\\Register\\Validator',
        ],
        'Onboarding\\V1\\Rpc\\Verify\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rpc\\Verify\\Validator',
        ],
        'Onboarding\\V1\\Rpc\\Reset\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rpc\\Reset\\Validator',
        ],
        'Onboarding\\V1\\Rpc\\Resend\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rpc\\Resend\\Validator',
        ],
        'Onboarding\\V1\\Rpc\\ResetWithToken\\Controller' => [
            'input_filter' => 'Onboarding\\V1\\Rpc\\ResetWithToken\\Validator',
        ],
    ],
    'input_filter_specs' => [
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
                            'message' => 'That email address is already registered.',
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
                            'message' => 'That email address is already registered.',
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
        'Onboarding\\V1\\Rpc\\Verify\\Validator' => [
        ],
        'Onboarding\\V1\\Rpc\\Reset\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Onboarding\Validator\ObjectExists::class,
                        'options' => [
                            'object_repository' => \Onboarding\Entity\Account::class,
                            'object_manager' => 'doctrine.entitymanager.orm_sqlsrv',
                            'fields' => [
                                0 => 'email',
                            ],
                            'message' => 'We couldn\'t find your account with that email.',
                        ],
                    ],
                    2 => [
                        'name' => \Onboarding\Validator\ObjectExists::class,
                        'options' => [
                            'object_repository' => \Application\Entity\Account::class,
                            'object_manager' => 'doctrine.entitymanager.orm_default',
                            'fields' => [
                                0 => 'email',
                            ],
                            'message' => 'We couldn\'t find your account with that email.',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'email',
                'description' => 'The email address.',
                'field_type' => 'string',
            ],
        ],
        'Onboarding\\V1\\Rpc\\Resend\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Onboarding\Validator\ObjectExists::class,
                        'options' => [
                            'object_repository' => \Onboarding\Entity\Account::class,
                            'object_manager' => 'doctrine.entitymanager.orm_sqlsrv',
                            'fields' => [
                                0 => 'email',
                            ],
                            'message' => 'We couldn\'t find your account with that email.',
                        ],
                    ],
                    2 => [
                        'name' => \Onboarding\Validator\ObjectExists::class,
                        'options' => [
                            'object_repository' => \Application\Entity\Account::class,
                            'object_manager' => 'doctrine.entitymanager.orm_default',
                            'fields' => [
                                0 => 'email',
                            ],
                            'message' => 'We couldn\'t find your account with that email.',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'email',
            ],
        ],
        'Onboarding\\V1\\Rpc\\ResetWithToken\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\NotEmpty::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'password',
                'field_type' => 'string',
                'continue_if_empty' => true,
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Onboarding\\V1\\Rpc\\Register\\Controller' => \Onboarding\V1\Rpc\Register\RegisterControllerFactory::class,
            'Onboarding\\V1\\Rpc\\Verify\\Controller' => \Onboarding\V1\Rpc\Verify\VerifyControllerFactory::class,
            'Onboarding\\V1\\Rpc\\Reset\\Controller' => \Onboarding\V1\Rpc\Reset\ResetControllerFactory::class,
            \Onboarding\Controller\ConsoleController::class => \Onboarding\Controller\ConsoleControllerFactory::class,
            'Onboarding\\V1\\Rpc\\Resend\\Controller' => \Onboarding\V1\Rpc\Resend\ResendControllerFactory::class,
            'Onboarding\\V1\\Rpc\\ResetWithToken\\Controller' => \Onboarding\V1\Rpc\ResetWithToken\ResetWithTokenControllerFactory::class,
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
        'Onboarding\\V1\\Rpc\\Resend\\Controller' => [
            'service_name' => 'resend',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'onboarding.rpc.resend',
        ],
        'Onboarding\\V1\\Rpc\\ResetWithToken\\Controller' => [
            'service_name' => 'resetWithToken',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'onboarding.rpc.reset-with-token',
        ],
    ],
];
