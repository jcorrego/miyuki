<?php

namespace App\Console\Commands;

use App\Models\Delica;
use Illuminate\Console\Command;
use Image;

class GenerateRGBColors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rgb-colors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process delicas to generate RGB colors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $delicas = Delica::where('rgb', '#000')->limit(10)->get();
        foreach ($delicas as $delica) {
            $image = Image::make($delica->image_color_url);
            $hex = $image->pickColor(10, 10, 'hex');
            $this->info('Processing delica ' . $delica->code . ' ' . $delica->image_color_url . ' ' . $hex . ' ...');
            $delica->rgb = $hex;
            $delica->save();
        }
    }
}
