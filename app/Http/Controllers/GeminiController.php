<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;
use Google\Client;
use Google\Service\YouTube;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Resource; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $MatchesName = [];
        $MatchesDescription = [];
        preg_match_all('/"(.*?)"/', $response, $MatchesName);
        preg_match_all('/\?(.*?)\?/', $response1, $MatchesDescription);
        $TaskNames = $MatchesName[1]; // 抽出された文字列の配列
        $TaskDescription = $MatchesDescription[1]; // 抽出された文字列の配列

        // YouTube API を使用して関連動画を取得
        $TaskVideos = $this->getYouTubeVideos($prompt);
        Log::info('Task Videos:', ['TaskVideos' => $TaskVideos]);
        return view('ask', compact('TaskNames', 'TaskDescription', 'TaskVideos'));
    }

    /**
     * YouTube API を使用して動画を取得
     */
    private function getYouTubeVideos($query)
    {
        $apiKey = env('YOUTUBE_API_KEY');
        $client = new \Google\Client();
        $client->setDeveloperKey($apiKey);

        $youtube = new \Google\Service\YouTube($client);

        try {
            $response = $youtube->search->listSearch('snippet', [
                'q' => $query,
                'maxResults' => 1,
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
   
    public function saveToDatabase(Request $request)
    {
        DB::beginTransaction();

        try {
            $prompt = $request->input('prompt');
            $TaskNames = json_decode($request->input('taskNames'), true) ?? [];
            $taskDescriptions = json_decode($request->input('taskDescriptions'), true) ?? [];
            $TaskVideos = json_decode($request->input('taskVideos'), true) ?? [];

            // ゴールを作成
            $goal = Goal::create([
                'title' => $prompt,
                'user_id' => Auth::id(),
            ]);

            // タスク詳細を3つずつ分割
            $chunkedDescriptions = array_chunk($taskDescriptions, 3);

            // タスクを保存
            foreach ($TaskNames as $index => $name) {
                // 各タスクの詳細を「 」で結合
                $description = implode(' ', $chunkedDescriptions[$index] ?? []);

                Task::create([
                    'goal_id' => $goal->id,
                    'name' => $name,
                    'description' => $description, // 結合した詳細を保存
                ]);
            }

            // リソースを保存
            foreach ($TaskVideos as $video) {
                Resource::create([
                    'goal_id' => $goal->id,
                    'title' => $video['title'],
                    'link' => $video['url'],
                ]);
            }

            DB::commit();

            return to_route('mypage')->with('success', 'タスクとリソースを保存しました！');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to save data:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'データの保存に失敗しました。');
        }
    }
}
