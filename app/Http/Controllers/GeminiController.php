<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Services\YouTubeService;
use Illuminate\Support\Facades\Log;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeminiController extends Controller
{
    protected $geminiService;
    protected $youTubeService;

    public function __construct(GeminiService $geminiService, YouTubeService $youTubeService)
    {
        $this->geminiService = $geminiService;
        $this->youTubeService = $youTubeService;
    }

    public function askQuestion(Request $request)
    {
        $prompt = $request->input('question');

        // タスクと詳細を生成
        $tasks = $this->geminiService->generateTasks($prompt);
        $taskDetails = $this->geminiService->generateTaskDetails($tasks);

        // タスク名と詳細を抽出
        $taskNames = $this->extractTaskNames($tasks);
        $taskDescriptions = $this->extractTaskDescriptions($taskDetails);

        // YouTube 動画を取得
        $taskVideos = $this->youTubeService->getVideos($prompt);

        return view('ask', compact('taskNames', 'taskDescriptions', 'taskVideos'));
    }

    public function saveToDatabase(Request $request)
    {
        DB::beginTransaction();

        try {
            // リクエストからデータを取得
            $prompt = $request->input('prompt');
            // タスク名、詳細、動画を取得。JSON形式から配列へ
            $taskNames = json_decode($request->input('taskNames'), true) ?? [];
            $taskDescriptions = json_decode($request->input('taskDescriptions'), true) ?? [];
            $taskVideos = json_decode($request->input('taskVideos'), true) ?? [];

            // ゴールを保存
            $goal = Goal::create([
                'title' => $prompt,
                'user_id' => Auth::id(),
            ]);

            // タスク詳細を3つずつ分割
            $chunkedDescriptions = array_chunk($taskDescriptions, 3);

            // タスクを保存
            foreach ($taskNames as $index => $name) {
                $description = implode(' ', $chunkedDescriptions[$index] ?? []);

                Task::create([
                    'goal_id' => $goal->id,
                    'name' => $name,
                    'description' => $description,
                ]);
            }

            // リソースを保存
            foreach ($taskVideos as $video) {
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

    private function extractTaskNames($response)
    {
        preg_match_all('/"(.*?)"/', $response, $matches);
        return $matches[1] ?? [];
    }

    private function extractTaskDescriptions($response)
    {
        preg_match_all('/\?(.*?)\?/', $response, $matches);
        return $matches[1] ?? [];
    }
}
