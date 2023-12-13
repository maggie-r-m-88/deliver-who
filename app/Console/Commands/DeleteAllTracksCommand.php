<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\DeleteAllTracksJob;

class DeleteAllTracksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:tracks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all tracks in library.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $job = new DeleteAllTracksJob();
        $job->handle();
                
        $this->info("All tracks have been deleted from library.");
    }
}
