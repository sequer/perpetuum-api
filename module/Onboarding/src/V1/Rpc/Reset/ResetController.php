<?php
namespace Onboarding\V1\Rpc\Reset;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Entity\{Account, Email};
use Application\Entity\Token\PasswordReset as PasswordResetToken;
use DateTime;

class ResetController extends AbstractActionController
{
    private $entityManager;
    private $mailer;

    public function __construct($entityManager, $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public function resetAction()
    {
        $email = $this->bodyParam('email');
        $account = $this->entityManager
            ->getRepository(Account::class)
            ->findOneBy([
                'email' => $email,
            ]);

        if (!$account) {
            throw new \Exception('Not found.', 404);
        }

        if (!$account->hasEmailConfirmed()) {
            throw new \Exception('That account has not yet been verified.', 422);
        }

        $token = new PasswordResetToken();
        $token->setAccount($account);
        $token->setHash(bin2hex(openssl_random_pseudo_bytes(16)));
        $token->setEmail($account->getEmail());
        $this->entityManager->persist($token);

        $email = new Email();
        $email->setName(Email::NAME_SITE_PASSWORD_RESET);
        $email->setEmail($account->getEmail());
        $email->setToken($token);
        $this->entityManager->persist($email);

        try {
            $response = $this->mailer->sendPasswordResetMail($token);
            $email->setSentOn(new DateTime('now'));
        } catch (\Exception $exception) {
            // do nothing
        }

        $this->entityManager->flush();

        return $this->getResponse()->setStatusCode(201);
    }
}
