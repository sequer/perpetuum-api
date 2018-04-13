<?php
namespace Onboarding\V1\Rpc\Resend;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Entity\{Account, Email};
use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;
use DateTime;

class ResendController extends AbstractActionController
{
    private $entityManager;
    private $mailer;

    public function __construct($entityManager, $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public function resendAction()
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

        if ($account->hasEmailConfirmed()) {
            throw new \Exception('That account was already verified.', 422);
        }

        $token = $this->entityManager
            ->getRepository(EmailConfirmationToken::class)
            ->findOneBy([
                'account' => $account,
                'consumedOn' => null,
            ]);

        if (!$token) {
            throw new \Exception('That account was already verified.', 422);
        }

        $email = new Email();
        $email->setName(Email::NAME_SITE_REGISTER_VERIFY);
        $email->setEmail($account->getEmail());
        $email->setToken($token);
        $this->entityManager->persist($email);

        try {
            $response = $this->mailer->sendActivationMail($token);
            $email->setSentOn(new DateTime('now'));
        } catch (Exception $exception) {
            // do nothing
        }

        $this->entityManager->flush();

        return $this->getResponse()->setStatusCode(201);
    }
}
