<?php
/**
 * Translation Locale Middleware
 *
 * @since     Sep 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace TranslationComponent\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TranslationComponent\Middleware\LocaleHandler\HandlerInterface;
use TranslationComponent\Translator\Translator;

class LocaleMiddleware implements MiddlewareInterface
{
    protected $handler;
    protected $container;

    public function __construct(ContainerInterface $container, HandlerInterface $handler)
    {
        $this->handler = $handler;
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param RequestHandlerInterface $handler
     * @return Response
     */
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        try {
            /** @var Translator $translator */
            $translator = $this->container->get($this->handler->handle($request) . '_locale');
            $translator->register();

        } catch (\Exception $e) {
            throw new \RuntimeException('Please check the translation module configuration!' . $e->getMessage());
        }

        return $handler->handle($request);
    }
}
