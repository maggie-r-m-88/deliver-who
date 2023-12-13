<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Track;
use App\Http\Controllers\Spotify\SpotifyAuthController as SpotifyAuthController;
use GuzzleHttp\Client;


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
        Log::info('Getting Tracks from Spotify');
        // Use the TestEntry model to query the MongoDB collection
        //$count = TestEntry::count();

        $collection = $this->getTracks($this->playlistId);

        $tracks = collect($collection['items']);

        //TODO uploadTracks() class goes here
        $tracks = collect($tracks)->map(function ($item) {
            if (is_array($item)) {
                $item = (object)$item;
            }
        
            $item->playlistId = $this->playlistId;
            unset($item->track['album']['available_markets']);
            unset($item->track['available_markets']);
            return $item;
        })->all();

        Log::info('Uploading playlist to MongoDB..');

        foreach ($tracks as &$track) {
            $trackModel = new Track;
            foreach ($track as $key => $value) {
                $trackModel->$key = $value;
            }
            $trackModel->save();
        }

        Log::info($this->playlistId);

    }

    private function getTracks($playlistId){

        $response = app(SpotifyAuthController::class)->authenticate();

        $accessToken = json_decode($response->getContent())->access_token;

        $client = new Client();

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken
        ];

        $url = 'https://api.spotify.com/v1/playlists/' . $playlistId . '/tracks';

        $response = $client->get($url, [
            'headers' => $headers,
        ]);

        $body = $response->getBody()->getContents();

        $decodedData = json_decode($body, true);

        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to decode JSON response'], 500);
        }

        return $decodedData;
    }

}
