<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

declare(strict_types = 1);

namespace Dot\Session\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class SessionOptions
 * @package Dot\Session\Options
 */
class SessionOptions extends AbstractOptions
{
    /** @var string */
    protected $sessionNamespace = 'dot_session';

    /** @var int */
    protected $rememberMeInactive = 1800;

    /**
     * @return string
     */
    public function getSessionNamespace(): string
    {
        return $this->sessionNamespace;
    }

    /**
     * @param string $sessionNamespace
     */
    public function setSessionNamespace(string $sessionNamespace)
    {
        $this->sessionNamespace = $sessionNamespace;
    }

    /**
     * @return int
     */
    public function getRememberMeInactive(): int
    {
        return $this->rememberMeInactive;
    }

    /**
     * @param int $rememberMeInactive
     */
    public function setRememberMeInactive(int $rememberMeInactive)
    {
        $this->rememberMeInactive = $rememberMeInactive;
    }
}
