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
            ->to('chakcrampon@gmail.com')
            ->subject('Un message de la page contact est disponible!')
            ->text("Le numéro est " . $data['numero'] . " " . " le nom est " . $data['nom'] ." " ."voici le message :". $data['message']);
        $this->monmail->send($email);



    }


}