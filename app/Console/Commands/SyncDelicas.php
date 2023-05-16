<?php

namespace App\Console\Commands;

use App\Models\Delica;
use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
        $content = file_get_contents(resource_path('1.html'));
        @$doc->loadHTML($content);
        $xpath = new DOMXPath($doc);
        $details = $xpath->query("//*[local-name()='img' and contains(concat(' ', normalize-space(@class), ' '), ' dxeImage ')]");
        $bar = $this->output->createProgressBar(count($details));
        $bar->start();
        $next = '2412';
        $found = false;
        foreach ($details as $detail) {
            $bar->advance();
            $src = trim($detail->getAttribute('src'));
            $parts = explode('/', $src);
            $filename = $parts[2]; // Get the filename '3941_small.jpg'
            $number = str_replace('_small.jpg', '', $filename); // Remove '_small.jpg' to get the number
            if ($number === $next) {
                $found = true;
            }
            if (!$found) {
                continue;
            }
            $this->info('Processing reference ' . $number . '...');
            $url = 'https://www.threadabead.com/Search_Select.aspx?shop=2&entry_id=' . $number;
            $parsedUrl = parse_url($url);
            parse_str($parsedUrl['query'], $queryParams);
            $reference = $queryParams['entry_id'] ?? null;

            $doc = new DOMDocument();
            $content = file_get_contents($url);
            @$doc->loadHTML($content);
            $title = $doc->getElementById('ThreadABead_ContentPlaceHolder1_lbl_header')->nodeValue;
            preg_match('/(?P<code>DBS \d{4}) (?P<name>[^\(]+)/', $title, $matches);
            if (!isset($matches['code'])) {
                preg_match('/(?P<code>DB \d{4}) (?P<name>[^\(]+)/', $title, $matches);
            }
            preg_match('/(?P<code>DB \d{4}) (?P<name>[^\(]+)/', $title, $matches);
            if (isset($matches['code'])) {
                $delica = Delica::firstOrNew([
                    'code' => $matches['code']
                ]);
                $delica->source_url = $url;
                $delica->name = $matches['name'];
                if ( !empty($reference)) {
                    $delica->image_photo_url = 'https://www.threadabead.com/shop_thumbs/' . $reference . '_2.jpg';
                    $delica->image_color_url = 'https://www.threadabead.com/shop_thumbs/' . $reference . '_3.jpg';
                }
                $xpath = new DOMXPath($doc);
                $details = $xpath->query("//*[local-name()='div' and contains(concat(' ', normalize-space(@class), ' '), ' Classification_Details ')]");
                foreach ($details as $detail) {
                    if ( Str::of($detail->nodeValue)->startsWith('Finish:') ){
                        $delica->finish = Str::of($detail->nodeValue)->after('Finish:')->trim();
                    }
                    elseif ( Str::of($detail->nodeValue)->startsWith('Colour:') ) {
                        $delica->color = Str::of($detail->nodeValue)->after('Colour:')->trim();
                    }
                    elseif ( Str::of($detail->nodeValue)->startsWith('Size:') ) {
                        $delica->size = Str::of($detail->nodeValue)->after('Size:')->trim();
                    }
                    elseif ( Str::of($detail->nodeValue)->startsWith('Material:') ) {
                        $delica->material = Str::of($detail->nodeValue)->after('Material:')->trim();
                    }
                    elseif ( Str::of($detail->nodeValue)->startsWith('Shape:') ) {
                        $delica->shape = Str::of($detail->nodeValue)->after('Shape:')->trim();
                    }
                    else {
                        // dump($detail->nodeValue);
                    }
                }
                $delica->save();
            }
        }

        $bar->finish();
        $this->info('The command was successful!');
    }
}
