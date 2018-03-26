<?php
namespace Onboarding\V1\Rpc\Register;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;
use Application\Entity\SentEmail;
use Onboarding\Entity\Account as PerpetuumAccount;
use Zend\InputFilter\{Input, InputFilter};
use Zend\Validator;

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

    /**
     * Action for route `/onboarding/register`.
     */
    public function registerAction()
    {
        $email = $this->bodyParam('email');
        $password = $this->bodyParam('password');

        $account = new PerpetuumAccount();
        $account->setEmail($email);
        $account->setPassword(sha1($password));
        $account->setHasEmailConfirmed(false);
        $account->setLeadSource(['host' => PerpetuumAccount::LEAD_SOURCE_API]);
        $this->perpetuumEntityManager->persist($account);

        $token = new EmailConfirmationToken();
        $token->setHash(bin2hex(openssl_random_pseudo_bytes(16)));
        $token->setEmail($account->getEmail());
        $this->entityManager->persist($token);

        $this->perpetuumEntityManager->flush();
        $this->entityManager->flush();

        $response = $this->sendActivationMail($account, $token);

        $sentEmail = new SentEmail();
        $sentEmail->setName(SentEmail::NAME_SITE_REGISTER_VERIFY);
        $sentEmail->setEmail($account->getEmail());
        $sentEmail->setToken($token);
        $this->entityManager->persist($sentEmail);

        $this->entityManager->flush();

        return $this->getResponse()->setStatusCode(201);
    }

    /**
     * Find accounts in the Perpetuum server database that don't have their mail confirmed and have not been sent
     * an email with an EmailConfirmation token before.
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

    private function sendActivationMail(PerpetuumAccount $account, EmailConfirmationToken $token)
    {
        return $this->sparkPost->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'Open Perpetuum Team',
                    'email' => 'no-reply@mail.openperpetuum.com',
                ],
                'subject' => 'Activate your account [no action required]',
                'html' => '<html><body><p>Hi there! You\'ve recently registered an account on the Open Perpetuum server. Click <a href="http://register.openperpetuum.com/#/activate/{{token}}">here</a> to activate your Open Perpetuum account.</p><p>PS: We are currently testing our registration system. Unfortunately, our mailing sandbox got lost and we\'re sending real emails! There\'s no need to do anything with this email now. After the testing period is over, you will probably receive an email like this one after registering asking you to confirm your email address. This will be primarely used to give you a way to recover a lost password. Thanks!</p></body></html>',
            ],
            'substitution_data' => [
                'token' => $token->getHash(),
            ],
            'recipients' => [
                [
                    'address' => [
                        // 'name' => '',
                        'email' => $account->getEmail(),
                    ],
                ],
            ],
        ]);
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
