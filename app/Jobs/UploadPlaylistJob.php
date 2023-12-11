<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UploadPlaylistJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The playlist ID.
     *
     * @var int
     */
    private $playlistId;

    /**
     * Create a new job instance.
     *
     * @param int $playlistId
     */
    public function __construct($playlistId)
    {
        $this->playlistId = $playlistId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Run the artisan command within the job
        Log::info('Uploading playlist to MongoDB..');
        Log::info($this->playlistId);
    }
}
