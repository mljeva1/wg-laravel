<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PlayerService
{
    protected $apiBaseUrl = 'https://api.worldoftanks.eu/wot/ratings/top/';
    protected $applicationId;

    public function __construct()
    {
        $this->applicationId = env('WARGAMING_APPLICATION_ID');
    }

    public function getTopPlayersByRating($rankField = 'battle_avg_xp', $limit = 20)
    {
        $response = Http::get($this->apiBaseUrl, [
            'application_id' => $this->applicationId,
            'rank_field' => $rankField,
            'limit' => $limit,
        ]);

        if ($response->failed()) {
            throw new \Exception('API request failed: ' . $response->body());
        }

        $data = $response->json();

        if ($data['status'] !== 'ok') {
            throw new \Exception('API error: ' . $data['error']['message']);
        }

        return $data['data']; // Vraća listu top igrača
    }
}