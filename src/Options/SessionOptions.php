<?php

declare(strict_types=1);

namespace Dot\Session\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * @template TValue
 * @template-extends AbstractOptions<TValue>
 */
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
