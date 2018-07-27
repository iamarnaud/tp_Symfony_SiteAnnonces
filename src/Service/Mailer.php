<?php

namespace App\Service;


use App\Entity\User;

class Mailer
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendEmail(User $user)
    {
        try {
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('arnaud.voiron@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->templating->render(
                    // templates/emails/registration.html.twig
                        'emails/register.html.twig',
                        array('name' => $user->getUsername())
                    ),
                    'text/html'
                )
            ;
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }

        $this->mailer->send($message);
    }

}