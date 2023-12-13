<?php

namespace App\Http\Controllers\Spotify;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SpotifyAuthController extends Controller
{
    //

    public function authenticate()
    {
        $client = new Client();

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $url = 'https://accounts.spotify.com/api/token';

         $postData = [
            'grant_type' => 'client_credentials',
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
        ];

        $encodedData = http_build_query($postData);

        $response = $client->post($url, [
            'headers' => $headers,
            'body' => $encodedData, 
        ]);

        $body = $response->getBody()->getContents();

        $decodedData = json_decode($body, true);

        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to decode JSON response'], 500);
        }

        $accessToken = $decodedData['access_token'];
        $tokenType = $decodedData['token_type'];
        $expiresIn = $decodedData['expires_in'];


        return response()->json([
            'access_token' => $accessToken,
            'token_type' => $tokenType,
            'expires_in' => $expiresIn,
        ]);
    }
}
