<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Services\YouTubeService;
use App\Services\TaskService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeminiController extends Controller
{
    protected $geminiService;
    protected $youTubeService;
    protected $taskService;

    public function __construct(GeminiService $geminiService, YouTubeService $youTubeService, TaskService $taskService)
    {
        $this->geminiService = $geminiService;
        $this->youTubeService = $youTubeService;
        $this->taskService = $taskService;
    }

    public function askQuestion(Request $request)
    {
        $prompt = $request->input('question');

        // タスクと詳細を生成
        $tasks = $this->geminiService->generateTasks($prompt);
        $taskDetails = $this->geminiService->generateTaskDetails($tasks);

        // タスク名と詳細を抽出
        $taskNames = $this->taskService->extractTaskNames($tasks);
        $taskDescriptions = $this->taskService->extractTaskDescriptions($taskDetails);

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
            $taskNames = json_decode($request->input('taskNames'), true) ?? [];
            $taskDescriptions = json_decode($request->input('taskDescriptions'), true) ?? [];
            $taskVideos = json_decode($request->input('taskVideos'), true) ?? [];

            // データを保存
            $this->taskService->saveGoalWithTasksAndResources($prompt, $taskNames, $taskDescriptions, $taskVideos);

            DB::commit();

            return to_route('mypage')->with('success', 'タスクとリソースを保存しました！');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to save data:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'データの保存に失敗しました。');
        }
    }
}
