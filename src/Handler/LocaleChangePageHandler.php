<?php

declare(strict_types=1);

namespace TranslationComponent\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TranslationComponent\Middleware\LocaleHandler\HandlerInterface;
use TranslationComponent\Service\Configuration;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionMiddleware;

class LocaleChangePageHandler implements RequestHandlerInterface
{
    protected $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \InvalidArgumentException
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        /** @var SessionInterface $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

        if ($session) {
            $params = $request->getQueryParams();
            $redirect = $params['redirect'] ?? '/';
            if (isset($params['locale']) && $this->configuration->getLocaleFile($params['locale'])) {
                $session->set(HandlerInterface::SESSION_KEY, $params['locale']);
            }

            return new RedirectResponse($redirect);
        }

        return new RedirectResponse('/');
    }
}
