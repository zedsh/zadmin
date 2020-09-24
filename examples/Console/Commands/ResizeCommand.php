<?php

namespace App\Console\Commands;

use App\Artist;
use App\Organizer;
use App\Place;
use Illuminate\Console\Command;

class ResizeCommand extends Command
{
    public function resizeArtists()
    {
        $artists = Artist::all();
        foreach ($artists as $artist) {
            if (!empty($artist->photo)) {
                $artist->resize(Artist::ARTIST_LIST_RESIZE, $artist->photo[0]['path']);
            }
        }
    }

     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected
        $signature = 'images:resize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected
        $description = 'Resize all images force';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public
    function handle()
    {
        $this->resizeArtists();
    }
}
