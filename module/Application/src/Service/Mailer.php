<?php

namespace Application\Service;

use Application\Entity\Token\EmailConfirmation as EmailConfirmationToken;

class Mailer
{
    private $sparkPost;

    public function __construct($sparkPost)
    {
        $this->sparkPost = $sparkPost;
    }

    public function sendActivationMail(EmailConfirmationToken $token)
    {
        return $this->sparkPost->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'Open Perpetuum Team',
                    'email' => 'no-reply@mail.openperpetuum.com',
                ],
                'subject' => 'Activate your account [no action required]',
                'html' => '<html><body><p>Hi there! You\'ve recently registered an account on the Open Perpetuum server. Click <a href="http://register.openperpetuum.com/verify/{{token}}">here</a> to activate your Open Perpetuum account.</p><p>PS: We are currently testing our registration system. Unfortunately, our mailing sandbox got lost and we\'re sending real emails! There\'s no need to do anything with this email now. After the testing period is over, you will probably receive an email like this one after registering asking you to confirm your email address. This will be primarely used to give you a way to recover a lost password. Thanks!</p></body></html>',
            ],
            'substitution_data' => [
                'token' => $token->getHash(),
            ],
            'recipients' => [
                [
                    'address' => [
                        // 'name' => '',
                        'email' => $token->getAccount()->getEmail(),
                    ],
                ],
            ],
        ]);
    }
}
