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
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'onboarding.rest.doctrine.account',
            1 => 'onboarding.rest.doctrine.character',
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
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
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
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Onboarding\\V1\\Rest\\Account\\AccountHydrator',
            ],
            \Onboarding\V1\Rest\Character\CharacterResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Onboarding\\V1\\Rest\\Character\\CharacterHydrator',
            ],
        ],
    ],
    'doctrine-hydrator' => [
        'Onboarding\\V1\\Rest\\Account\\AccountHydrator' => [
            'entity_class' => \Onboarding\Entity\Account::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => false,
            'strategies' => [
                'characters' => 'ZF\Doctrine\Hydrator\Strategy\CollectionExtract',
            ],
            'use_generated_hydrator' => true,
        ],
        'Onboarding\\V1\\Rest\\Character\\CharacterHydrator' => [
            'entity_class' => \Onboarding\Entity\Character::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => false,
            'strategies' => [
                'account' => 'ZF\Doctrine\Hydrator\Strategy\EntityLink',
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
    ],
];
