<?php

namespace Onboarding\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Onboarding\Entity\Account as PerpetuumAccount;
use Application\Entity\{Account, Token};
use Zend\InputFilter\{Input, InputFilter};
use Zend\Validator;
use DateTime;

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

    public function findAction()
    {
        dump('Getting unconfirmed Perpetuum server accounts.');

        $result = $this->getUnconfirmedAccounts();

        foreach ($result as $row) {
            $perpetuumAccount = $row[0];

            if (!$perpetuumAccount instanceof PerpetuumAccount) {
                $this->perpetuumEntityManager->clear();

                continue;
            }

            if (!$this->isValidEmail($perpetuumAccount->getEmail())) {
                dump(sprintf(
                    'Invalid email address \'%s\' for Perpetuum account #%s.',
                    $perpetuumAccount->getEmail(),
                    $perpetuumAccount->getId()
                ));

                $this->perpetuumEntityManager->clear();

                continue;
            }

            $account = $this->entityManager
                ->getRepository(Account::class)
                ->findOneBy([
                    'email' => $perpetuumAccount->getEmail(),
                ]);

            if ($account) {
                if ($account->hasEmailConfirmed()) {
                    dump(sprintf(
                        'Site account #%s was confirmed, setting Perpetuum account #%s to confirmed.',
                        $account->getId(),
                        $perpetuumAccount->getId()
                    ));

                    $perpetuumAccount->setHasEmailConfirmed(true);
                    $this->perpetuumEntityManager->flush();
                    $this->perpetuumEntityManager->clear();
                    $this->entityManager->clear();

                    continue;
                }

                $token = $this->entityManager
                    ->getRepository(EmailConfirmationToken::class)
                    ->findOneBy([
                        'email' => $account->getEmail(),
                    ]);

                if ($token && $token->getConsumedOn() === null) {
                    dump(sprintf(
                        'Site account #%s was previously sent an email confirmation token.',
                        $account->getId()
                    ));

                    $this->entityManager->clear();
                    $this->perpetuumEntityManager->clear();

                    continue;
                }
            }

            if (!$account) {
                dump(sprintf(
                    'No site account for Perpetuum account #%s, creating one now.',
                    $perpetuumAccount->getId()
                ));

                $account = new Account();
                $account->setEmail($perpetuumAccount->getEmail());
                $account->setPassword($perpetuumAccount->getPassword());
                $this->entityManager->persist($account);
            }

            $token = new EmailConfirmationToken();
            $token->setAccount($account);
            $token->setHash(bin2hex(openssl_random_pseudo_bytes(16)));
            $token->setEmail($account->getEmail());
            $this->entityManager->persist($token);

            $email = new Email();
            $email->setName(Email::NAME_SERVER_REGISTER_VERIFY);
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
            $this->entityManager->clear();

            $this->perpetuumEntityManager->flush();
            $this->perpetuumEntityManager->clear();
        }
    }


    private function getUnconfirmedAccounts()
    {
        $query = $this->perpetuumEntityManager->createQueryBuilder()
            ->select('a')
            ->from(PerpetuumAccount::class, 'a')
            ->where('a.hasEmailConfirmed = ?1')
            ->andWhere('a.email LIKE ?2')
            ->andWhere('a.createdOn > ?3')
            ->orderBy('a.createdOn', 'DESC')
            ->getQuery();

        $query->setParameter(1, false);
        $query->setParameter(2, '%@%');
        $query->setParameter(3, new DateTime('-1 week'));

        $result = $query->iterate();

        return $result;
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
