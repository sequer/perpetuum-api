<?php
namespace Onboarding\V1\Rpc\Register;

class RegisterControllerFactory
{
    public function __invoke($controllers)
    {
        return new RegisterController();
    }
}
