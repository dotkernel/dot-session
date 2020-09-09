<?php


namespace Dot\Session;

use Dot\Session\Options\SessionOptions;
use Frontend\User\Authentication\PersistentAuthenticationAdapter;
use Frontend\User\Entity\UserIdentity;
use Frontend\User\Entity\UserToken;
use Frontend\User\Service\UserTokenService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Session\SessionManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class AutoLoginMiddleware
 * @package Dot\Session
 */
class AutoLoginMiddleware implements MiddlewareInterface
{

    /** @var SessionManager $sessionManager */
    protected $sessionManager;

    /** @var SessionOptions $options */
    private SessionOptions $options;

    /** @var AuthenticationServiceInterface $authenticationService */
    protected AuthenticationServiceInterface $authenticationService;

    /** @var PersistentAuthenticationAdapter $adapter */
    protected PersistentAuthenticationAdapter $adapter;

    /** @var UserTokenService $userTokenService */
    private UserTokenService $userTokenRepository;

    /**
     * AutoLoginMiddleware constructor.
     * @param SessionManager $sessionManager
     * @param SessionOptions $options
     * @param AuthenticationServiceInterface $authenticationService
     * @param PersistentAuthenticationAdapter $adapter
     * @param UserTokenService $userTokenService
     */
    public function __construct(
        SessionManager $sessionManager,
        SessionOptions $options,
        AuthenticationServiceInterface $authenticationService,
        PersistentAuthenticationAdapter $adapter,
        UserTokenService $userTokenService
    )
    {
        $this->sessionManager = $sessionManager;
        $this->options = $options;
        $this->authenticationService = $authenticationService;
        $this->adapter = $adapter;
        $this->userTokenService = $userTokenService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $config = $this->sessionManager->getConfig();
        if ($config->getUseCookies() && ! $this->authenticationService->hasIdentity()) {
            $key = $this->options->getCookieName();
            $rememberMe = $request->getCookieParams()[$key] ?? null;
            if (is_null($rememberMe)) {
                return $handler->handle($request);
            }
            /** @var UserToken $token */
            $token = $this->userTokenService->findOneBy(['value' => base64_decode($rememberMe)]);
            if ($token instanceof UserToken && ! $token->isTokenExpired()) {
                $this->authenticationService->setAdapter($this->adapter);
                $this->adapter->setIdentity($token->getUser()->getIdentity());
                $authResult = $this->authenticationService->authenticate();
                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $this->authenticationService->getStorage()->write($identity);
                } else {
                    $this->userTokenService->destroyToken($token);
                }
            }
        }
        return $handler->handle($request);
    }
}