<?php
return [
    'service_manager' => [
        'factories' => [
            'attacker_entity_filter' => \Killboard\V1\Rest\Attacker\AttackerFilterFactory::class,
            'agent_entity_filter' => \Killboard\V1\Rest\Agent\AgentFilterFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'killboard.rest.doctrine.kill' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/killboard/kill[/:kill_id]',
                    'defaults' => [
                        'controller' => 'Killboard\\V1\\Rest\\Kill\\Controller',
                    ],
                ],
            ],
            'killboard.rest.doctrine.attacker' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/killboard/attacker[/:attacker_id]',
                    'defaults' => [
                        'controller' => 'Killboard\\V1\\Rest\\Attacker\\Controller',
                    ],
                ],
            ],
            'killboard.rest.doctrine.agent' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/killboard/agent[/:agent_id]',
                    'defaults' => [
                        'controller' => 'Killboard\\V1\\Rest\\Agent\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            2 => 'killboard.rest.doctrine.kill',
            0 => 'killboard.rest.doctrine.attacker',
            3 => 'killboard.rest.doctrine.agent',
        ],
    ],
    'zf-rest' => [
        'Killboard\\V1\\Rest\\Kill\\Controller' => [
            'listener' => \Killboard\V1\Rest\Kill\KillResource::class,
            'route_name' => 'killboard.rest.doctrine.kill',
            'route_identifier_name' => 'kill_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'kill',
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
            'entity_class' => \Killboard\Entity\Kill::class,
            'collection_class' => \Killboard\V1\Rest\Kill\KillCollection::class,
            'service_name' => 'Kill',
        ],
        'Killboard\\V1\\Rest\\Attacker\\Controller' => [
            'listener' => \Killboard\V1\Rest\Attacker\AttackerResource::class,
            'route_name' => 'killboard.rest.doctrine.attacker',
            'route_identifier_name' => 'attacker_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'attacker',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Killboard\Entity\Attacker::class,
            'collection_class' => \Killboard\V1\Rest\Attacker\AttackerCollection::class,
            'service_name' => 'Attacker',
        ],
        'Killboard\\V1\\Rest\\Agent\\Controller' => [
            'listener' => \Killboard\V1\Rest\Agent\AgentResource::class,
            'route_name' => 'killboard.rest.doctrine.agent',
            'route_identifier_name' => 'agent_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'agent',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Killboard\Entity\Agent::class,
            'collection_class' => \Killboard\V1\Rest\Agent\AgentCollection::class,
            'service_name' => 'Agent',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Killboard\\V1\\Rest\\Kill\\Controller' => 'HalJson',
            'Killboard\\V1\\Rest\\Attacker\\Controller' => 'HalJson',
            'Killboard\\V1\\Rest\\Agent\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Killboard\\V1\\Rest\\Kill\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Killboard\\V1\\Rest\\Attacker\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Killboard\\V1\\Rest\\Agent\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Killboard\\V1\\Rest\\Kill\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/json',
            ],
            'Killboard\\V1\\Rest\\Attacker\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/json',
            ],
            'Killboard\\V1\\Rest\\Agent\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Killboard\Entity\Kill::class => [
                'route_identifier_name' => 'kill_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.kill',
                'hydrator' => 'Killboard\\V1\\Rest\\Kill\\KillHydrator',
            ],
            \Killboard\V1\Rest\Kill\KillCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.kill',
                'is_collection' => true,
            ],
            \Killboard\Entity\Attacker::class => [
                'route_identifier_name' => 'attacker_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.attacker',
                'hydrator' => 'Killboard\\V1\\Rest\\Attacker\\AttackerHydrator',
            ],
            \Killboard\V1\Rest\Attacker\AttackerCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.attacker',
                'is_collection' => true,
            ],
            \Killboard\Entity\Agent::class => [
                'route_identifier_name' => 'agent_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.agent',
                'hydrator' => 'Killboard\\V1\\Rest\\Agent\\AgentHydrator',
            ],
            \Killboard\V1\Rest\Agent\AgentCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.agent',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-apigility' => [
        'doctrine-connected' => [
            'Killboard\\V1\\Rest\\Group\\GroupResource' => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Killboard\\V1\\Rest\\Group\\GroupHydrator',
            ],
            \Killboard\V1\Rest\Kill\KillResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Killboard\\V1\\Rest\\Kill\\KillHydrator',
            ],
            \Killboard\V1\Rest\Attacker\AttackerResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Killboard\\V1\\Rest\\Attacker\\AttackerHydrator',
            ],
            \Killboard\V1\Rest\Agent\AgentResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Killboard\\V1\\Rest\\Agent\\AgentHydrator',
            ],
        ],
    ],
    'doctrine-hydrator' => [
        'Killboard\\V1\\Rest\\Kill\\KillHydrator' => [
            'entity_class' => \Killboard\Entity\Kill::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [
                'attackers' => \ZF\Doctrine\Hydrator\Strategy\CollectionExtract::class,
            ],
            'use_generated_hydrator' => true,
        ],
        'Killboard\\V1\\Rest\\Attacker\\AttackerHydrator' => [
            'entity_class' => \Killboard\Entity\Attacker::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'filters' => [
                [
                    'filter' => 'attacker_entity_filter',
                ],
            ],
            'use_generated_hydrator' => true,
            'strategies' => [],
        ],
        'Killboard\\V1\\Rest\\Agent\\AgentHydrator' => [
            'entity_class' => \Killboard\Entity\Agent::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'filters' => [
                [
                    'filter' => 'agent_entity_filter',
                ],
            ],
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
    ],
    'zf-content-validation' => [
        'Killboard\\V1\\Rest\\Kill\\Controller' => [
            'input_filter' => 'Killboard\\V1\\Rest\\Kill\\Validator',
        ],
        'Killboard\\V1\\Rest\\Attacker\\Controller' => [
            'input_filter' => 'Killboard\\V1\\Rest\\Attacker\\Validator',
        ],
        'Killboard\\V1\\Rest\\Agent\\Controller' => [
            'input_filter' => 'Killboard\\V1\\Rest\\Agent\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Killboard\\V1\\Rest\\Kill\\Validator' => [
            0 => [
                'name' => 'uid',
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
                'name' => 'damageReceived',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'date',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'Killboard\\V1\\Rest\\Attacker\\Validator' => [
            0 => [
                'name' => 'totalEcmAttempts',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
            1 => [
                'name' => 'successfulEcmAttempts',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
            2 => [
                'name' => 'demobilisations',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
            3 => [
                'name' => 'sensorSuppressions',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
            4 => [
                'name' => 'energyDispersed',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            5 => [
                'name' => 'damageDealt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            6 => [
                'name' => 'hasKillingBlow',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            7 => [
                'name' => 'hasMostDamage',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'Killboard\\V1\\Rest\\Agent\\Validator' => [
            0 => [
                'name' => 'uid',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
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
        ],
    ],
];
