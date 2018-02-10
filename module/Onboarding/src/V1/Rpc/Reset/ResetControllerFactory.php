<?php
namespace Onboarding\V1\Rpc\Reset;

class ResetControllerFactory
{
    public function __invoke($controllers)
    {
        return new ResetController();
    }
}
