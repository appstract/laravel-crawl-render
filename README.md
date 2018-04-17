# [Wip] Laravel Crawler Pre-render

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appstract/laravel-crawl-render.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-crawl-render)
[![Total Downloads](https://img.shields.io/packagist/dt/appstract/laravel-crawl-render.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-crawl-render)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

A simple package to pre-render your Javascript site for web crawlers like Google bot to improve your SEO.

It uses Spatie's [Crawler](https://github.com/spatie/crawler) and [Browsershot](https://github.com/spatie/browsershot) to crawl your website and store the HTML. 
Crawlers (detected by [Jaybizzle's Crawler Detect](https://github.com/JayBizzle/Crawler-Detect)) are getting the pre-rendered version served.

## Installation

You can install the package via composer:

``` bash
composer require appstract/laravel-crawl-render
```

You need Puppeteer installed for Browsershot to work, see: [https://github.com/spatie/browsershot#requirements](https://github.com/spatie/browsershot#requirements) 

## Usage
First add the middleware to any routes you want to Pre-render.

``` php
\Appstract\CrawlRender\Middleware\CrawlerPrerenderMiddleware::class
```

Then run the crawler to pre-render your site:
``` php
php artisan prerender:crawl
```

You can run this command regularly, for example after a deploy or with a schedule:

``` php
// app/console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('prerender:crawl')->daily()->at('02:00');
}
```

## Testing

``` bash
composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/appstract/laravel-crawl-render/graphs/contributors) :)

## About Appstract

Appstract is a small team from The Netherlands. We create (open source) tools for webdevelopment and write about related subjects on [Medium](https://medium.com/appstract). You can [follow us on Twitter](https://twitter.com/teamappstract), [buy us a beer](https://www.paypal.me/teamappstract/10) or [support us on Patreon](https://www.patreon.com/appstract).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
