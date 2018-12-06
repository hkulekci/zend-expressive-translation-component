<?php
/**
 * Session Handler
 *
 * @since     Nov 2018
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace TranslationComponent\Middleware\LocaleHandler;

use Psr\Http\Message\RequestInterface;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionMiddleware;

class Session implements HandlerInterface
{
    public function handle(RequestInterface $request): string
    {
        /** @var SessionInterface $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        if ($session) {
            $locale = $session->get(HandlerInterface::SESSION_KEY);
        }

        return $locale ?? 'en';
    }
}
