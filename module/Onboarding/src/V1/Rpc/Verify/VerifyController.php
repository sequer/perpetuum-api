<?php
namespace Onboarding\V1\Rpc\Verify;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\{ApiProblem, ApiProblemResponse};
use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;
use Application\Entity\Account;
use Onboarding\Entity\Account as PerpetuumAccount;
use DateTime;

class VerifyController extends AbstractActionController
{
	public function __construct($entityManager, $perpetuumEntityManager)
    {
        $this->entityManager = $entityManager;
        $this->perpetuumEntityManager = $perpetuumEntityManager;
    }

    public function verifyAction()
    {
        $token = $this->entityManager->getRepository(EmailConfirmationToken::class)->findOneBy([
        	'hash' => $this->routeParam('token'),
        	'consumedOn' => null,
        ]);

        if (!$token) {
        	return new ApiProblemResponse(new ApiProblem(404, 'Token invalid or expired.'));
        }

        if ($token->getAccount()->hasEmailConfirmed() === true) {
            $this->entityManager->flush();

            return new ApiProblemResponse(new ApiProblem(404, 'Token expired.'));
        }

        $perpetuumAccount = $this->perpetuumEntityManager
            ->getRepository(PerpetuumAccount::class)
            ->findOneBy([
                'email' => $token->getAccount()->getEmail()
            ]);

        if (!$perpetuumAccount) {
            $perpetuumAccount = new PerpetuumAccount();
            $perpetuumAccount->setEmail($token->getAccount()->getEmail());
            $perpetuumAccount->setLeadSource(['host' => PerpetuumAccount::LEAD_SOURCE_API]);
            $this->perpetuumEntityManager->persist($perpetuumAccount);
        }

        $token->setConsumedOn(new DateTime('now'));
        $token->getAccount()->setHasEmailConfirmed(true);
        $perpetuumAccount->setPassword($token->getAccount()->getPassword());
        $perpetuumAccount->setHasEmailConfirmed(true);

        $this->entityManager->flush();
        $this->perpetuumEntityManager->flush();

    	return $this->getResponse()->setStatusCode(204);
    }
}
