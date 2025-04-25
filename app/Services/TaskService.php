<?php

namespace App\Services;

use App\Models\Goal;
use App\Models\Task;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function extractTaskNames($response)
    {
        preg_match_all('/"(.*?)"/', $response, $matches);
        return $matches[1] ?? [];
    }

    public function extractTaskDescriptions($response)
    {
        preg_match_all('/\?(.*?)\?/', $response, $matches);
        return $matches[1] ?? [];
    }

    public function saveGoalWithTasksAndResources($prompt, $taskNames, $taskDescriptions, $taskVideos)
    {
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
    }
}