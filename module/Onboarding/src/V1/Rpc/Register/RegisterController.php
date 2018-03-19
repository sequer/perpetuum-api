<?php
namespace Onboarding\V1\Rpc\Register;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;
use Onboarding\Entity\Account;

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

        $token = new EmailConfirmationToken();
        $token->setHash(bin2hex(openssl_random_pseudo_bytes(16)));
        $token->setEmail($email);

        $this->perpetuumEntityManager->persist($account);
        $this->perpetuumEntityManager->flush();

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        $response = $this->sendActivationMail($account, $token);

        return $this->getResponse()->setStatusCode(204);
    }

    private function sendActivationMail(Account $account, EmailConfirmation $token)
    {
        return $this->sparkPost->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'Open Perpetuum Team',
                    'email' => 'no-reply@openperpetuum.com',
                ],
                'subject' => 'Activate your account',
                'html' => '<html><body><h1>Congratulations, {{name}}!</h1><p>You just sent your very first mailing!</p>Click <a href="/activate/{{hash}}">here</a> to activate your account.</body></html>',
            ],
            'substitution_data' => [
                'token' => $token->getHash()
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
