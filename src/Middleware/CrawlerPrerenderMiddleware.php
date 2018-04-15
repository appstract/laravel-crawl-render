<?php

namespace Appstract\CrawlRender\Middleware;

use Closure;
use Storage;
use Jaybizzle\LaravelCrawlerDetect\Facades\LaravelCrawlerDetect as Crawler;

class CrawlerPrerenderMiddleware
{
    /**
     * @param         $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $response = $next($request);

        if (Crawler::isCrawler() && $this->hasPrerenderedView($request->getPathInfo())) {
            $response->setContent(
                $this->getPrerenderedView($request->getPathInfo())
            );
        }

        return $response;
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    protected function hasPrerenderedView($path)
    {
        return Storage::disk('local')->exists('prerendered'.$path.'/dom.html');
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    protected function getPrerenderedView($path)
    {
        return Storage::disk('local')->get('prerendered'.$path.'/dom.html');
    }
}
