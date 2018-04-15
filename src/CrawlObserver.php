<?php

namespace Appstract\CrawlRender;

use Storage;
use Psr\Http\Message\UriInterface;
use Spatie\Browsershot\Browsershot;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlObserver extends \Spatie\Crawler\CrawlObserver
{
    protected $consoleOutput;

    public function __construct(OutputInterface $consoleOutput)
    {
        $this->consoleOutput = $consoleOutput;
    }

    /**
     * Called when the crawler will crawl the url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     */
    public function willCrawl(UriInterface $url)
    {
        $this->consoleOutput->writeln('Crawling: '.$url->getPath());
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null)
    {
        Storage::disk('local')->put('prerendered/'.$url->getPath().'/dom.html',
            Browsershot::url($url)->waitUntilNetworkIdle()->bodyHtml()
        );
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null)
    {
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling()
    {
    }
}
