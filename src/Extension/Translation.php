<?php
/**
 * Translation Middleware
 *
 * @since     Oct 2018
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace TranslationComponent\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Translation extends AbstractExtension
{
    public function __(string $original): string
    {
        return __($original);
    }

    public function noop__(string $original): string
    {
        return noop__($original);
    }

    public function n__(string $original, string $plural, string $value): string
    {
        return n__($original, $plural, $value);
    }

    public function p__(string $context, string $original): string
    {
        return p__($context, $original);
    }

    public function d__(string $domain, string $original): string
    {
        return d__($domain, $original);
    }

    public function dp__(string $domain, string $context, string $original): string
    {
        return dp__($domain, $context, $original);
    }

    public function dn__(string $domain, string $original, string $plural, string $value)
    {
        return dn__($domain, $original, $plural, $value);
    }

    public function np__(string $context, string $original, string $plural, string $value)
    {
        return np__($context, $original, $plural, $value);
    }

    public function dnp__(string $domain, string $context, string $original, string $plural, string $value)
    {
        return dnp__($domain, $context, $original, $plural, $value);
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions() : array
    {
        return [
            new TwigFunction('trans', [$this, '__']),
            new TwigFunction('noop_trans', [$this, 'noop__']),
            new TwigFunction('n_trans', [$this, 'n__']),
            new TwigFunction('p_trans', [$this, 'p__']),
            new TwigFunction('d_trans', [$this, 'd__']),
            new TwigFunction('dp_trans', [$this, 'dp__']),
            new TwigFunction('dn_trans', [$this, 'dn__']),
            new TwigFunction('np_trans', [$this, 'np__']),
            new TwigFunction('dnp_trans', [$this, 'dnp__']),
        ];
    }
}
