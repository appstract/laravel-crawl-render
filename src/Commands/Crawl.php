<?php

namespace Appstract\CrawlRender\Commands;

use Storage;
use Spatie\Crawler\Crawler;
use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\CrawlInternalUrls;
use Appstract\CrawlRender\CrawlObserver;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Crawl extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'prerender:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the prerender crawler';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Removing old stuff');
        Storage::disk('local')->deleteDirectory('prerendered');

        $output->writeln('Starting crawler');

        Crawler::create()
            ->setCrawlObserver(new CrawlObserver($output))
            ->setCrawlProfile(new CrawlInternalUrls(config('app.url')))
            ->executeJavaScript()
            //->setBrowsershot((new Browsershot())->waitUntilNetworkIdle())
            ->setBrowsershot((new Browsershot())->setDelay(1500))
            ->startCrawling(config('app.url'));
    }
}
