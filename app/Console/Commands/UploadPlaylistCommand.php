<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UploadPlaylistJob;

class UploadPlaylistCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:playlist {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload a playlist to track library';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Access the playlist ID argument
        $playlistId = $this->argument('id');

        // Instantiate the job and call its handle method directly
        $job = new UploadPlaylistJob($playlistId);
        $job->handle();
        
        $this->info("Playlist with ID {$playlistId} uploaded successfully.");
    }
}
