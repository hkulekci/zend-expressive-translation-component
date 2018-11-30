<?php
/**
 * Handler Interface
 *
 * @since     Nov 2018
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace TranslationComponent\Middleware\Handler;

use Psr\Http\Message\RequestInterface;

interface HandlerInterface
{
    public const SESSION_KEY = 'locale';
    public const REQUEST_HEADER_KEY = 'locale';

    public function handle(RequestInterface $request): string;
}
