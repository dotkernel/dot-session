<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

namespace DotKernel\DotSession\Options;


use Zend\Stdlib\AbstractOptions;

/**
 * Class SessionOptions
 * @package DotKernel\DotSession\Options
 */
class SessionOptions extends AbstractOptions
{
    /** @var string  */
    protected $sessionNamespace = 'dot_session';

    /**
     * @return string
     */
    public function getSessionNamespace()
    {
        return $this->sessionNamespace;
    }

    /**
     * @param string $sessionNamespace
     * @return SessionOptions
     */
    public function setSessionNamespace($sessionNamespace)
    {
        $this->sessionNamespace = $sessionNamespace;
        return $this;
    }

}