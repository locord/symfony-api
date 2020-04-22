<?php

declare(strict_types=1);

namespace App\Email;

use App\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Mailer
 * @package App\Email
 */
class Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(
        Swift_Mailer $mailer,
        Environment $twig
    ) {
        $this->mailer = $mailer;
        $this->twig   = $twig;
    }

    /**
     * @param User $user
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render(
            'email/confirmation.html.twig',
            [
                'user' => $user,
            ]
        );

        $message = (new Swift_Message('Please confirm your account!'))
            ->setFrom('api-platform@api.com')
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}
