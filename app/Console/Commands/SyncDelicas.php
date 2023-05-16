<?php

namespace App\Console\Commands;

use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;

class SyncDelicas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-delicas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync delicas database from internet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $doc = new DOMDocument();
        $url = 'https://www.threadabead.com/Delica_Colours.aspx';
        $content = file_get_contents($url);
        @$doc->loadHTML($content);
        $xpath = new DOMXPath($doc);
        $details = $xpath->query("//*[local-name()='img' and contains(concat(' ', normalize-space(@class), ' '), ' dxeImage ')]");
        $bar = $this->output->createProgressBar(count($details));
        $bar->start();
        foreach ($details as $detail) {
            $bar->advance();
        }

        $bar->finish();
        $this->info('The command was successful!');
    }
}
