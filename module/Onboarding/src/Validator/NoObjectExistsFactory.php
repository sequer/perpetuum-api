<?php

namespace Onboarding\Validator;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class NoObjectExistsFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NoObjectExists
	{
		$options['object_manager'] = $container->get($options['object_manager']);
		$options['object_repository'] = $options['object_manager']->getRepository($options['object_repository']);

		return new NoObjectExists($options);
	}
}