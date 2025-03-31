<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;
use Google\Client;
use Google\Service\YouTube;

class GeminiController extends Controller
{
    public function askQuestion(Request $request)
    {
        // リクエストの内容を$promptに格納
        $prompt = $request->input('question');

        $goal = <<<EOD
            #目標{$prompt}を達成するまでのタスクを作成してください。
            １から順に番号をつけて記入してください。
            最大で15件まで記入可能です。
            Phase などは必要ありません
            項目ごとに""で囲ってください
            (例)
            1. "タスク1"
            2. "タスク2"
            EOD;
            $response = Gemini::generativeModel("gemini-2.0-flash")->generateContent($goal)->text();

        $goal1 = <<<EOD
           
            #設定したタスクについて詳細を各タスクにつき3つずつ出力してください
            タスクごとに""で囲ってください
            内容は?で囲ってください
            以下の例のように出力してください
            例）
            1.
            2.
            3.
            {$response}
            EOD;
            $response1 = Gemini::generativeModel("gemini-2.0-flash")->generateContent($goal1)->text();

            // YouTube API を使用して動画を検索
            $client = new Client();
            $client->setDeveloperKey(env('YOUTUBE_API_KEY'));
            $youtube = new YouTube($client);

            $terms = $youtube->search->listSearch('snippet', [
                'q' => $prompt,
                'maxResults' => 10,
                'type' => 'video',
                'order' => 'relevance',
            ]); 

            $TaskVideo = collect($terms->getItems())->map(function ($item) {
                return [
                    'title' => $item['snippet']['title'],
                    'url' => 'https://www.youtube.com/watch?v=' . $item['id']['videoId'],
                ];
            });
            // ダミーデータ
           
            // $TaskVideo = [
            //         ['title' => 'Example Video 1', 'url' => 'https://www.youtube.com/watch?v=abc123'],
            //         ['title' => 'Example Video 2', 'url' => 'https://www.youtube.com/watch?v=def456'],
            //         ['title' => 'Example Video 3', 'url' => 'https://www.youtube.com/watch?v=ghi789'],
            //         ['title' => 'Example Video 4', 'url' => 'https://www.youtube.com/watch?v=jkl012'],
            //         ['title' => 'Example Video 5', 'url' => 'https://www.youtube.com/watch?v=mno345'],
            //         ['title' => 'Example Video 6', 'url' => 'https://www.youtube.com/watch?v=pqr678'],
            // ];
            
            $Matchesname = [];
            $Matchesdescription = [];
            preg_match_all('/"(.*?)"/', $response, $Matchesname);
            preg_match_all('/\?(.*?)\?/', $response1, $Matchesdescription);
            $Tasknames = $Matchesname[1]; // 抽出された文字列の配列
            $Taskdescription = $Matchesdescription[1]; // 抽出された文字列の配列

            return view('ask', compact('Tasknames','Taskdescription','TaskVideo'));
        }
    }
