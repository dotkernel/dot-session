<?php
/**
 * @see https://github.com/dotkernel/dot-session/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-session/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Session\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Class SessionOptions
 * @package Dot\Session\Options
 */
class SessionOptions extends AbstractOptions
{

    const COOKIE_DEFAULT_NAME = 'remember_me_token';

    /** @var int */
    protected $rememberMeInactive = 1800;

    /** @var string $cookieName */
    protected $cookieName = 1800;
    
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

    public function getCookieName(): string
    {
        return $this->cookieName;
    }

    public function setCookieName(string $name = self::COOKIE_DEFAULT_NAME)
    {
        $this->cookieName = $name;
    }
}
