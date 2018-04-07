<?php

namespace Onboarding\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Onboarding\Entity\{
    Account as PerpetuumAccount,
    Character as PerpetuumCharacter,
    Item as PerpetuumItem,
    Zone as PerpetuumZone,
    Kill as PerpetuumKill
};
use Killboard\Entity as Killboard;
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
        // $dictionaryData = file_get_contents(__DIR__.'/../../../../data/gbf/dictionary.txt');
        // $dictionary = $this->unpackGenxy($dictionaryData);
        // dump($dictionary);
        // exit;

        $query = $this->perpetuumEntityManager->createQueryBuilder()
            ->select('k')
            ->from(PerpetuumKill::class, 'k')
            ->andWhere('k.occuredOn > ?1')
            ->orderBy('k.occuredOn', 'DESC')
            ->getQuery();
        $query->setParameter(1, new DateTime('-100 week'));
        $result = $query->iterate();


        foreach ($result as $row) {
            $perpetuumKill = $row[0];

            $kill = $this->entityManager->getRepository(Killboard\Kill::class)->findOneBy([
                'uid' => $perpetuumKill->getUid(),
            ]);
            if ($kill) {
                // continue;
            }

            $data = $this->unpackGenxy($perpetuumKill->getData());
            $enrichedData = $this->enrichKillFromPerpetuum($data);

            $kill = new Killboard\Kill();
            $kill->setUid($perpetuumKill->getUid());
            $kill->setDate($perpetuumKill->getOccuredOn());
            $this->entityManager->persist($kill);

            $agent = $this->upsertEntity(Killboard\Agent::class, $enrichedData['victim']['characterID']);
            $agent->setName($enrichedData['victim']['nick']);
            $kill->setAgent($agent);

            $corporation = $this->upsertEntity(Killboard\Corporation::class, $enrichedData['victim']['corporation']);
            $kill->setCorporation($corporation);
            $agent->setCorporation($corporation);

            $robot = $this->upsertEntity(Killboard\Robot::class, $enrichedData['victim']['robot']);
            $kill->setRobot($robot);

            $zone = $this->upsertEntity(Killboard\Zone::class, $enrichedData['zone']);
            $kill->setZone($zone);

            $this->entityManager->flush();

            foreach ($enrichedData['attackers'] as $attackerData) {
                $attacker = new Killboard\Attacker();
                $attacker->setKill($kill);
                $attacker->setDamageDealt($attackerData['damageDone']);
                $this->entityManager->persist($attacker);

                $agent = $this->upsertEntity(Killboard\Agent::class, $attackerData['characterID']);
                $agent->setName($attackerData['nick']);
                $attacker->setAgent($agent);

                $corporation = $this->upsertEntity(Killboard\Corporation::class, $attackerData['corporation']);
                $agent->setCorporation($corporation);
                $attacker->setCorporation($corporation);

                $robot = $this->upsertEntity(Killboard\Robot::class, $attackerData['robot']);
                $attacker->setRobot($robot);

                $kill->setDamageReceived(bcadd($kill->getDamageReceived(), $attackerData['damageDone'], 4));

                $this->entityManager->flush();
            }






            dump($enrichedData);
            dump($kill);


            // dump($kill->getData());
            // dump($data);
            // dump($enrichedData);

            $this->entityManager->clear();
        }
    }

    private function upsertEntity($className, $identifier) // move to factory
    {
        if ($className === Killboard\Agent::class) {
            $result = $this->entityManager->getRepository($className)->findOneBy([
                'uid' => $identifier,
            ]);

            if (!$result) {
                $result = new $className();
                $result->setUid($identifier);
                $this->entityManager->persist($result);
            }

            return $result;
        }

        if ($className === Killboard\Corporation::class) {
            $result = $this->entityManager->getRepository($className)->findOneBy([
                'name' => $identifier,
            ]);

            if (!$result) {
                $result = new $className();
                $result->setName($identifier);
                $this->entityManager->persist($result);
            }

            return $result;
        }

        if ($className === Killboard\Zone::class) {
            $result = $this->entityManager->getRepository($className)->findOneBy([
                'definition' => $identifier->getName(),
            ]);

            if (!$result) {
                $result = new $className();
                $result->setDefinition($identifier->getName());
                $this->entityManager->persist($result);
            }

            return $result;
        }

        if ($className === Killboard\Robot::class) {
            $result = $this->entityManager->getRepository($className)->findOneBy([
                'definition' => $identifier->getName(),
            ]);

            if (!$result) {
                $result = new $className();
                $result->setDefinition($identifier->getName());
                $this->entityManager->persist($result);
            }

            return $result;
        }

        return false;
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

    private function unpackGenxy($data)
    {
        $result = [];

        if (is_string($data)) {
            $data = trim($data);
        }

        if (!is_array($data) && preg_match('/^\|a\d+=\[/s', $data, $match)) {
            $data = preg_split('/\|a\d+/', $data);
        }

        if (!is_array($data) && strpos($data, '#') === 0) {
            $data = explode('#', substr($data, 1));
            if (count($data) === 1) {
                // return $data;
            }
        }
        if (!is_array($data) && strpos($data, '|') === 0) {
            $data = explode('|', substr($data, 1));
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
                    $_value = $pair[1];
                    $_value = base_convert($_value, 16, 10);
                    $result[$pair[0]] = (int) $_value;
                    continue;
                }
            }
            if (strstr($value, '=$')) {
                $pair = explode('=$', $value);
                if (count($pair) === 2) {
                    $result[$pair[0]] = (string) trim($pair[1]);
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
            if (preg_match('/=\[(.+)\]/s', $value, $match)) {
                $pair = explode('=[', $value);
                if ($pair[0]) {
                    $result[$pair[0]] = $this->unpackGenxy($match[1]);
                    continue;
                }

                $result[] = $this->unpackGenxy($match[1]);
                continue;
            }
        }

        return $result;
    }

    private function enrichKillFromPerpetuum(array $data)
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
}
