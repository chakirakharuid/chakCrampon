<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


class Email{

    private $monmail;
    public function __construct(MailerInterface $mail)
    {
        $this->monmail = $mail;
    }


    public function email($data){

        $email = new TemplatedEmail();
        $email->from($data['email'])
            ->to('admin@example.com')
            ->subject('Un message de la page contact est disponible!')
            ->text("Le numéro est " . $data['numero'] . "" . "le nom est " . $data['nom']);
        $this->monmail->send($email);



    }


}