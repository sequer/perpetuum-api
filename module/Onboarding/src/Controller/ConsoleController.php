<?php

namespace Onboarding\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Onboarding\Entity\{
    Account as PerpetuumAccount,
    Character as PerpetuumCharacter,
    Item as PerpetuumItem,
    Zone as PerpetuumZone
};
use Onboarding\Entity\Kill as PerpetuumKill;
use Application\Entity\{Account, Email};
use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;
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
            } catch (\Exception $exception) {
                // do nothing
            }

            $this->entityManager->flush();
            $this->entityManager->clear();

            $this->perpetuumEntityManager->flush();
            $this->perpetuumEntityManager->clear();
        }
    }

    public function killAction()
    {
        $query = $this->perpetuumEntityManager->createQueryBuilder()
            ->select('k')
            ->from(PerpetuumKill::class, 'k')
            ->andWhere('k.createdOn > ?1')
            ->orderBy('k.createdOn', 'DESC')
            ->getQuery();

        $query->setParameter(1, new DateTime('-1 week'));

        $result = $query->iterate();
        foreach ($result as $row) {
            $kill = $row[0];

            $data = $this->unpackGenxy($kill->getData());
            $enrichedData = $this->enrichKillData($data);

            dump($kill->getData(), $data, $enrichedData);
        }
    }

    private function enrichKillData(array $data)
    {
        if (isset($data['zoneID'])) {
            $data['zone'] = $this->perpetuumEntityManager->find(PerpetuumZone::class, $data['zoneID']);
        }
        if (isset($data['victim']['robot'])) {
            $data['victim']['robot'] = $this->perpetuumEntityManager->find(PerpetuumItem::class, $data['victim']['robot']);
        }
        if (isset($data['victim']['characterID'])) {
            $data['victim']['character'] = $this->perpetuumEntityManager->find(PerpetuumCharacter::class, $data['victim']['characterID']);
        }

        foreach ($data['attackers'] as $key => $attacker) {
            $data['attackers'][$key]['robot'] = $this->perpetuumEntityManager->find(PerpetuumItem::class, $attacker['robot']);
            $data['attackers'][$key]['character'] = $this->perpetuumEntityManager->find(PerpetuumCharacter::class, $attacker['characterID']);
        }

        return $data;
    }

    private function unpackGenxy($data)
    {
        $result = [];

        if (!is_array($data) && preg_match('/^\|a(\d+)=\[/', $data, $match)) {
            $data = preg_split('/\|a\d+/', $data);
            unset($data[0]); // always empty
            foreach ($data as $key => $value) {
                $data[$key] = $match[$key].$value;
            }
            dump($data);
        }

        if (!is_array($data) && strpos($data, '#') === 0) {
            $data = explode('#', $data);
            if (count($data) === 1) {
                return $data;
            }
        }
        if (!is_array($data) && strpos($data, '|') === 0) {
            $data = explode('|', $data);
            if (count($data) === 1) {
                return $data;
            }
        }

        foreach ($data as $key => $value) {
            if ($value === "") {
                continue;
            }
            if (strstr($value, '=i')) {
                $pair = explode('=i', $value);
                if (count($pair) === 2) {
                    $result[$pair[0]] = (int) $pair[1];
                    continue;
                }
            }
            if (strstr($value, '=$')) {
                $pair = explode('=$', $value);
                if (count($pair) === 2) {
                    $result[$pair[0]] = (string) $pair[1];
                    continue;
                }
            }
            if (strstr($value, '=t')) {
                $pair = explode('=t', $value);
                if (count($pair) === 2) {
                    $_value = $pair[1];
                    $_value = unpack('f', hex2bin($_value));
                    $_value = reset($_value);
                    $result[$pair[0]] = $_value;
                    continue;
                }
            }
            if (preg_match('/=\[(.+)\]/', $value, $match)) {
                $pair = explode('=[', $value);
                $result[$pair[0]] = $this->unpackGenxy($match[1]);
                continue;
            }
        }

        return $result;
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
