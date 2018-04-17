<?php
return [
    'zf-apigility-doctrine-query-provider' => [
        'aliases' => [
            'default_orm' => \ZF\Doctrine\QueryBuilder\Query\Provider\DefaultOrm::class,
            'default_odm' => \ZF\Doctrine\QueryBuilder\Query\Provider\DefaultOdm::class,
        ],
        'factories' => [
            \ZF\Doctrine\QueryBuilder\Query\Provider\DefaultOrm::class => \ZF\Doctrine\QueryBuilder\Query\Provider\DefaultOrmFactory::class,
            \ZF\Doctrine\QueryBuilder\Query\Provider\DefaultOdm::class => \ZF\Doctrine\QueryBuilder\Query\Provider\DefaultOdmFactory::class,
        ],
    ],
    'zf-doctrine-querybuilder-orderby-orm' => [
        'aliases' => [
            'field' => \ZF\Doctrine\QueryBuilder\OrderBy\ORM\Field::class,
        ],
        'factories' => [
            \ZF\Doctrine\QueryBuilder\OrderBy\ORM\Field::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
    'zf-doctrine-querybuilder-filter-orm' => [
        'aliases' => [
            'eq' => \ZF\Doctrine\QueryBuilder\Filter\ORM\Equals::class,
        ],
        'factories' => [
            \ZF\Doctrine\QueryBuilder\Filter\ORM\Equals::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
];
