<?php

/*
 * This file is part of the NucleosUserBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\UserBundle\Mailer\Mail;

use Nucleos\UserBundle\Model\UserInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;

final class ResettingMail extends TemplatedEmail
{
    /**
     * @var string
     */
    private $confirmationUrl;

    /**
     * @var UserInterface
     */
    private $user;

    public function __construct(Headers $headers = null, AbstractPart $body = null)
    {
        parent::__construct($headers, $body);

        $this->htmlTemplate('@NucleosUser/Resetting/email.txt.twig');
    }

    public function setConfirmationUrl(string $confirmationUrl): self
    {
        $this->confirmationUrl = $confirmationUrl;

        return $this;
    }

    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getConfirmationUrl(): string
    {
        return $this->confirmationUrl;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getContext(): array
    {
        return array_merge([
            'confirmationUrl' => $this->getConfirmationUrl(),
            'user'            => $this->getUser(),
        ], parent::getContext());
    }
}
