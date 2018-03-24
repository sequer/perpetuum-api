<?php
namespace Onboarding\V1\Rpc\Verify;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\{ApiProblem, ApiProblemResponse};
use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;
use Onboarding\Entity\Account;
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
        $hash = $this->bodyParam('hash');

        $token = $this->entityManager->getRepository(EmailConfirmationToken::class)->findOneBy([
        	'hash' => $hash, 
        	'consumedOn' => null
        ]);

        if (!$token) {
        	return new ApiProblemResponse(new ApiProblem(404, 'Entity not found'));
        }

        $account = $this->perpetuumEntityManager->getRepository(Account::class)->findOneBy([
        	'email' => $token->getEmail(),
        ]);

        if (!$account) {
        	return new ApiProblemResponse(new ApiProblem(404, 'Entity not found'));
        }

        $token->setConsumedOn(new DateTime('now'));
        $account->setHasEmailConfirmed(true);

        $this->entityManager->flush();
        $this->perpetuumEntityManager->flush();

    	return $this->getResponse()->setStatusCode(204);
    }
}
