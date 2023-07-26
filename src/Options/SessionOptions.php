<?php

/**
 * @see https://github.com/dotkernel/dot-session/ for the canonical source repository
 */

declare(strict_types=1);

namespace Dot\Session\Options;

use Laminas\Stdlib\AbstractOptions;

class SessionOptions extends AbstractOptions
{
    protected int $rememberMeInactive = 1800;

    public function getRememberMeInactive(): int
    {
        return $this->rememberMeInactive;
    }

    public function setRememberMeInactive(int $rememberMeInactive): void
    {
        $this->rememberMeInactive = $rememberMeInactive;
    }
}
