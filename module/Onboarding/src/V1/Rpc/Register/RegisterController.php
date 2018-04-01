<?php
namespace Onboarding\V1\Rpc\Register;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Entity\{Account, Email};
use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;
use Zend\InputFilter\{Input, InputFilter};
use Zend\Validator;
use Exception;
use DateTime;

class RegisterController extends AbstractActionController
{
    private $entityManager;
    private $mailer;

    public function __construct($entityManager, $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public function registerAction()
    {
        $email = $this->bodyParam('email');
        $password = $this->bodyParam('password');

        $account = new Account();
        $account->setEmail($email);
        $account->setPassword(sha1($password));
        $this->entityManager->persist($account);

        $token = new EmailConfirmationToken();
        $token->setAccount($account);
        $token->setHash(bin2hex(openssl_random_pseudo_bytes(16)));
        $token->setEmail($account->getEmail());
        $this->entityManager->persist($token);

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
