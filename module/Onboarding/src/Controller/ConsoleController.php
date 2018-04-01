<?php

namespace Onboarding\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ConsoleController extends AbstractActionController
{
    private $entityManager;
    private $perpetuumEntityManager;
    private $mailer;

    public function __construct($entityManager, $perpetuumEntityManager, $mailer)
    {
        $this->entityManager = $entityManager;
        $this->perpetuumEntityManager = $perpetuumEntityManager;
        $this->mailer = $mailer;
    }

    /**
     *
     */
    public function findAction()
    {
        $accounts = $this->getUnconfirmedAccounts();

        foreach ($accounts as $account) {
            dump($account);

            if ($this->isValidEmail($account->getEmail()) === false) {
                dump(sprintf('Invalid email address \'%s\'', $account->getEmail()));

                continue;
            }

            $token = $this->entityManager
                ->getRepository(EmailConfirmationToken::class)
                ->findOneBy([
                    'email' => $account->getEmail()
                ]);
            if ($token) {
                dump('Confirmation mail already sent.');

                continue;
            }

            $token = new EmailConfirmationToken();
            $token->setHash(bin2hex(openssl_random_pseudo_bytes(16)));
            $token->setEmail($account->getEmail());
            $this->entityManager->persist($token);

            $this->entityManager->flush();

            $response = $this->sendActivationMail($account, $token);

            $sentEmail = new SentEmail();
            $sentEmail->setName(SentEmail::NAME_SERVER_REGISTER_VERIFY);
            $sentEmail->setEmail($account->getEmail());
            $sentEmail->setToken($token);
            $this->entityManager->persist($sentEmail);

            $this->entityManager->flush();
        }
    }


    private function getUnconfirmedAccounts($limit = 10)
    {
        $query = $this->perpetuumEntityManager->createQueryBuilder()
            ->select('a')
            ->from(PerpetuumAccount::class, 'a')
            ->where('a.hasEmailConfirmed = ?1')
            ->andWhere('a.email IS NOT NULL')
            ->orderBy('a.createdOn', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
        $query->setParameter(1, false);

        return $query->getResult();
    }

    private function isValidEmail($email): bool
    {
        $input = new Input('email');
        $input->getValidatorChain()->attach(new Validator\EmailAddress());
        $inputFilter = new InputFilter();
        $inputFilter->add($input);
        $inputFilter->setData(['email' => $email]);

        return $inputFilter->isValid();
    }
}
