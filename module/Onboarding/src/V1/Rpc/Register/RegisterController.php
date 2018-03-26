<?php
namespace Onboarding\V1\Rpc\Register;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;
use Onboarding\Entity\{Account, ExtensionPointsAddedLog};

class RegisterController extends AbstractActionController
{
    private $entityManager;
    private $perpetuumEntityManager;
    private $sparkPost;

    public function __construct($entityManager, $perpetuumEntityManager, $sparkPost)
    {
        $this->entityManager = $entityManager;
        $this->perpetuumEntityManager = $perpetuumEntityManager;
        $this->sparkPost = $sparkPost;
    }

    public function registerAction()
    {
        $email = $this->bodyParam('email');
        $password = $this->bodyParam('password');

        $account = new Account();
        $account->setEmail($email);
        $account->setPassword(sha1($password));
        $account->setHasEmailConfirmed(false);
        $account->setLeadSource(['host' => Account::LEAD_SOURCE_API]);
        $this->perpetuumEntityManager->persist($account);

        $token = new EmailConfirmationToken();
        $token->setHash(bin2hex(openssl_random_pseudo_bytes(16)));
        $token->setEmail($email);
        $this->entityManager->persist($token);

        $this->perpetuumEntityManager->flush();
        $this->entityManager->flush();

        $response = $this->sendActivationMail($account, $token);

        return $this->getResponse()->setStatusCode(201);
    }

    private function sendActivationMail(Account $account, EmailConfirmationToken $token)
    {
        return $this->sparkPost->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'Open Perpetuum Team',
                    'email' => 'no-reply@mail.openperpetuum.com',
                ],
                'subject' => 'Activate your account',
                'html' => '<html><body><p>Hi there! Click <a href="http://register.openperpetuum.com/activate/?token={{token}}">here</a> to activate your account.</p></body></html>',
            ],
            'substitution_data' => [
                'token' => $token->getHash(),
            ],
            'recipients' => [
                [
                    'address' => [
                        'name' => '',
                        'email' => $account->getEmail(),
                    ],
                ],
            ],
        ]);
    }
}
