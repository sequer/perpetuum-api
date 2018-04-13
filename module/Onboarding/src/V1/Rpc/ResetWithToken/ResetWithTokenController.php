<?php
namespace Onboarding\V1\Rpc\ResetWithToken;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Entity\Token\PasswordReset as PasswordResetToken;
use ZF\ApiProblem\{ApiProblem, ApiProblemResponse};
use Onboarding\Entity\Account as PerpetuumAccount;
use DateTime;

class ResetWithTokenController extends AbstractActionController
{
    private $entityManager;
    private $perpetuumEntityManager;

    public function __construct($entityManager, $perpetuumEntityManager)
    {
        $this->entityManager = $entityManager;
        $this->perpetuumEntityManager = $perpetuumEntityManager;
    }

    public function resetWithTokenAction()
    {
        $token = $this->entityManager->getRepository(PasswordResetToken::class)->findOneBy([
            'hash' => $this->routeParam('token'),
            'consumedOn' => null,
        ]);

        if (!$token || !$token->getAccount()) {
            return new ApiProblemResponse(new ApiProblem(404, 'Token invalid or expired.'));
        }

        if (!$this->bodyParam('password')) {
            return $this->getResponse()->setStatusCode(204);
        }

        $perpetuumAccount = $this->perpetuumEntityManager
            ->getRepository(PerpetuumAccount::class)
            ->findOneBy(['email' => $token->getAccount()->getEmail()]);

        $token->setConsumedOn(new DateTime('now'));
        $token->getAccount()->setPassword(sha1($this->bodyParam('password')));
        $perpetuumAccount->setPassword(sha1($this->bodyParam('password')));

        $this->entityManager->flush();
        $this->perpetuumEntityManager->flush();

        return $this->getResponse()->setStatusCode(201);
    }
}
