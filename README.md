# Zend Expressive Translation Component

Use composer to install

```
composer require hkulekci/translation-component
```

And put the `\TranslationComponent\ModuleConfig::class` in your `config.php` file.

There is a console interface in this library. You can check the command with `bin/console` command or you can integrate with your console interface. To do that check the `src/config/module.config.php` configuration file.

There is a page handler (`\TranslationComponent\Handler\LocaleChangePageHandler`) to change the language on session. We have already had a route for this. We are using session to handle language in the application. Also, there is a `RequestHeader` handler. In future, we will add some other handler like `path`.

On the other hand, we have some middleware to handle importing translation file to application. Please check the `\TranslationComponent\Middleware\TranslationMiddleware` class for this.

Lastly, for now, we support only for twig. Not other type of renderer for the Zend Expressive.
