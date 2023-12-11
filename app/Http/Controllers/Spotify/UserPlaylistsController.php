<?php

namespace App\Http\Controllers\Spotify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Spotify\SpotifyAuthController as SpotifyAuthController;
use GuzzleHttp\Client;

class UserPlaylistsController extends Controller
{
    //
    public function show(Request $request){

        $response = app(SpotifyAuthController::class)->authenticate($request);

        $accessToken = json_decode($response->getContent())->access_token;

        $client = new Client();

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken
        ];

        $url = 'https://api.spotify.com/v1/users/ailbita/playlists';

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
