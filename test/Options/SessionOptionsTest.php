<?php

declare(strict_types=1);

namespace DotTest\Session\Options;

use Dot\Session\Options\SessionOptions;
use PHPUnit\Framework\TestCase;

class SessionOptionsTest extends TestCase
{
    public function testGetRememberMeInactive(): void
    {
        $sessionOptions = new SessionOptions();
        $this->assertIsInt($sessionOptions->getRememberMeInactive());
    }

    public function testSetRememberMeInactive(): void
    {
        $sessionOptions = new SessionOptions();
        $sessionOptions->setRememberMeInactive(100);
        $this->assertEquals(100, $sessionOptions->getRememberMeInactive());
    }
}
