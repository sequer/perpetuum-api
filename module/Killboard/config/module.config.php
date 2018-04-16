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
            'killboard.rest.doctrine.corporation' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/killboard/corporation[/:corporation_id]',
                    'defaults' => [
                        'controller' => 'Killboard\\V1\\Rest\\Corporation\\Controller',
                    ],
                ],
            ],
            'killboard.rest.doctrine.robot' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/killboard/robot[/:robot_id]',
                    'defaults' => [
                        'controller' => 'Killboard\\V1\\Rest\\Robot\\Controller',
                    ],
                ],
            ],
            'killboard.rest.doctrine.zone' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/killboard/zone[/:zone_id]',
                    'defaults' => [
                        'controller' => 'Killboard\\V1\\Rest\\Zone\\Controller',
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
            4 => 'killboard.rest.doctrine.corporation',
            5 => 'killboard.rest.doctrine.robot',
            6 => 'killboard.rest.doctrine.zone',
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
            ],
            'collection_http_methods' => [
                0 => 'GET',
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
        'Killboard\\V1\\Rest\\Corporation\\Controller' => [
            'listener' => \Killboard\V1\Rest\Corporation\CorporationResource::class,
            'route_name' => 'killboard.rest.doctrine.corporation',
            'route_identifier_name' => 'corporation_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'corporation',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Killboard\Entity\Corporation::class,
            'collection_class' => \Killboard\V1\Rest\Corporation\CorporationCollection::class,
            'service_name' => 'Corporation',
        ],
        'Killboard\\V1\\Rest\\Robot\\Controller' => [
            'listener' => \Killboard\V1\Rest\Robot\RobotResource::class,
            'route_name' => 'killboard.rest.doctrine.robot',
            'route_identifier_name' => 'robot_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'robot',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Killboard\Entity\Robot::class,
            'collection_class' => \Killboard\V1\Rest\Robot\RobotCollection::class,
            'service_name' => 'Robot',
        ],
        'Killboard\\V1\\Rest\\Zone\\Controller' => [
            'listener' => \Killboard\V1\Rest\Zone\ZoneResource::class,
            'route_name' => 'killboard.rest.doctrine.zone',
            'route_identifier_name' => 'zone_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'zone',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Killboard\Entity\Zone::class,
            'collection_class' => \Killboard\V1\Rest\Zone\ZoneCollection::class,
            'service_name' => 'Zone',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Killboard\\V1\\Rest\\Kill\\Controller' => 'HalJson',
            'Killboard\\V1\\Rest\\Attacker\\Controller' => 'HalJson',
            'Killboard\\V1\\Rest\\Agent\\Controller' => 'HalJson',
            'Killboard\\V1\\Rest\\Corporation\\Controller' => 'HalJson',
            'Killboard\\V1\\Rest\\Robot\\Controller' => 'HalJson',
            'Killboard\\V1\\Rest\\Zone\\Controller' => 'HalJson',
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
            'Killboard\\V1\\Rest\\Corporation\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Killboard\\V1\\Rest\\Robot\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Killboard\\V1\\Rest\\Zone\\Controller' => [
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
            'Killboard\\V1\\Rest\\Corporation\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/json',
            ],
            'Killboard\\V1\\Rest\\Robot\\Controller' => [
                0 => 'application/vnd.killboard.v1+json',
                1 => 'application/json',
            ],
            'Killboard\\V1\\Rest\\Zone\\Controller' => [
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
            \Killboard\Entity\Corporation::class => [
                'route_identifier_name' => 'corporation_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.corporation',
                'hydrator' => 'Killboard\\V1\\Rest\\Corporation\\CorporationHydrator',
            ],
            \Killboard\V1\Rest\Corporation\CorporationCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.corporation',
                'is_collection' => true,
            ],
            \Killboard\Entity\Robot::class => [
                'route_identifier_name' => 'robot_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.robot',
                'hydrator' => 'Killboard\\V1\\Rest\\Robot\\RobotHydrator',
            ],
            \Killboard\V1\Rest\Robot\RobotCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.robot',
                'is_collection' => true,
            ],
            \Killboard\Entity\Zone::class => [
                'route_identifier_name' => 'zone_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.zone',
                'hydrator' => 'Killboard\\V1\\Rest\\Zone\\ZoneHydrator',
            ],
            \Killboard\V1\Rest\Zone\ZoneCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'killboard.rest.doctrine.zone',
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
            \Killboard\V1\Rest\Corporation\CorporationResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Killboard\\V1\\Rest\\Corporation\\CorporationHydrator',
            ],
            \Killboard\V1\Rest\Robot\RobotResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Killboard\\V1\\Rest\\Robot\\RobotHydrator',
            ],
            \Killboard\V1\Rest\Zone\ZoneResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Killboard\\V1\\Rest\\Zone\\ZoneHydrator',
            ],
        ],
    ],
    'doctrine-hydrator' => [
        'Killboard\\V1\\Rest\\Kill\\KillHydrator' => [
            'entity_class' => \Killboard\Entity\Kill::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [
                'date' => \Application\Doctrine\Hydrator\Strategy\DateTimeExtractStrategy::class,
                'attackers' => \ZF\Doctrine\Hydrator\Strategy\CollectionExtract::class,
            ],
            'use_generated_hydrator' => true,
        ],
        'Killboard\\V1\\Rest\\Attacker\\AttackerHydrator' => [
            'entity_class' => \Killboard\Entity\Attacker::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'filters' => [
                0 => [
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
                0 => [
                    'filter' => 'agent_entity_filter',
                ],
            ],
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'Killboard\\V1\\Rest\\Corporation\\CorporationHydrator' => [
            'entity_class' => \Killboard\Entity\Corporation::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'Killboard\\V1\\Rest\\Robot\\RobotHydrator' => [
            'entity_class' => \Killboard\Entity\Robot::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'Killboard\\V1\\Rest\\Zone\\ZoneHydrator' => [
            'entity_class' => \Killboard\Entity\Zone::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
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
        'Killboard\\V1\\Rest\\Corporation\\Controller' => [
            'input_filter' => 'Killboard\\V1\\Rest\\Corporation\\Validator',
        ],
        'Killboard\\V1\\Rest\\Robot\\Controller' => [
            'input_filter' => 'Killboard\\V1\\Rest\\Robot\\Validator',
        ],
        'Killboard\\V1\\Rest\\Zone\\Controller' => [
            'input_filter' => 'Killboard\\V1\\Rest\\Zone\\Validator',
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
        'Killboard\\V1\\Rest\\Corporation\\Validator' => [
            0 => [
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
        'Killboard\\V1\\Rest\\Robot\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => false,
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
                'name' => 'definition',
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
        'Killboard\\V1\\Rest\\Zone\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => false,
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
                'name' => 'definition',
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
