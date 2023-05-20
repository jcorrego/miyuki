<?php

namespace App\Console\Commands;

use App\Models\Delica;
use Illuminate\Console\Command;
use Image;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process delicas images to optimize them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $delicas = Delica::where('image_photo_url', 'like', 'http%')->limit(50)->get();
        foreach ($delicas as $delica) {
            $this->info('Processing delica ' . $delica->code . ' ' . $delica->image_photo_url . ' ...');
            $image = Image::make($delica->image_photo_url)->widen(320)->save('public/images/delicas/' . $delica->code . '.jpg', 60, 'jpg');
            $delica->image_photo_url = '/images/delicas/' . $delica->code . '.jpg';
            $delica->save();
        }
    }
}
