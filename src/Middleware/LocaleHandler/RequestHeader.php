<?php
/**
 * Request Header
 *
 * @since     Nov 2018
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace TranslationComponent\Middleware\LocaleHandler;

use Psr\Http\Message\RequestInterface;

class RequestHeader implements HandlerInterface
{
    public function handle(RequestInterface $request): string
    {
        return $request->getHeaderLine('locale') ?? 'en';
    }
}
