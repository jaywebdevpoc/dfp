<?php

/*
 * (c) 2004-2009 Chris Corbyn
 *
 */

/**
 * Sends Messages over SMTP with ESMTP support.
 *
 *
 * @method Swift_SmtpTransport setUsername(string $username) Set the username to authenticate with.
 * @method string              getUsername()                 Get the username to authenticate with.
 * @method Swift_SmtpTransport setPassword(string $password) Set the password to authenticate with.
 * @method string              getPassword()                 Get the password to authenticate with.
 * @method Swift_SmtpTransport setAuthMode(string $mode)     Set the auth mode to use to authenticate.
 * @method string              getAuthMode()                 Get the auth mode to use to authenticate.
 */
class Swift_SmtpTransport extends Swift_Transport_EsmtpTransport
{
    /**
     * @param string $host
     * @param int    $port
     * @param string $encryption
     */
    public function __construct($host = 'localhost', $port = 25, $encryption = null)
    {
        call_user_func_array(
            [$this, 'Swift_Transport_EsmtpTransport::__construct'],
            Swift_DependencyContainer::getInstance()
                ->createDependenciesFor('transport.smtp')
            );

        $this->setHost($host);
        $this->setPort($port);
        $this->setEncryption($encryption);
    }
}
