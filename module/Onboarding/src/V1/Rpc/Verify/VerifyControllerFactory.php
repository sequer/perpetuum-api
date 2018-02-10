<?php
namespace Onboarding\V1\Rpc\Verify;

class VerifyControllerFactory
{
    public function __invoke($controllers)
    {
        return new VerifyController();
    }
}
