<?php

namespace App\Services;

use Google\Client;
use Google\Service\YouTube;
use Illuminate\Support\Facades\Log;

class YouTubeService
{
    /**
     * YouTube API を使用して動画を取得
     */
    public function getVideos($query)
    {
        $apiKey = env('YOUTUBE_API_KEY');
        $client = new Client();
        $client->setDeveloperKey($apiKey);

        $youtube = new YouTube($client);

        try {
            $response = $youtube->search->listSearch('snippet', [
                'q' => $query,
                'maxResults' => 5,
                'type' => 'video',
            ]);

            $videos = collect();

            foreach ($response->getItems() as $item) {
                $videos->push([
                    'title' => $item['snippet']['title'],
                    'url' => 'https://www.youtube.com/watch?v=' . $item['id']['videoId'],
                ]);
            }

            return $videos;
        } catch (\Exception $e) {
            Log::error('YouTube API Error: ' . $e->getMessage());
            return collect(); // 空のコレクションを返す
        }
    }
}