<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;

class GeminiService
{
    /**
     * タスクを生成するためのプロンプトを作成
     */
    public function generateTasks($prompt)
    {
        $goalPrompt = <<<EOD
            #目標{$prompt}を達成するまでのタスクを作成してください。
            １から順に番号をつけて記入してください。
            最大で15件まで記入可能です。
            Phase などは必要ありません
            項目ごとに""で囲ってください
            (例)
            1. "タスク1"
            2. "タスク2"
        EOD;

        return Gemini::generativeModel("gemini-2.0-flash")->generateContent($goalPrompt)->text();
    }

    /**
     * タスク詳細を生成するためのプロンプトを作成
     */
    public function generateTaskDetails($tasks)
    {
        $detailsPrompt = <<<EOD
            #設定したタスクについて詳細を各タスクにつき3つずつ出力してください
            タスクごとに""で囲ってください
            内容は?で囲ってください
            以下の例のように出力してください
            例）
            1.
            2.
            3.
            {$tasks}
        EOD;

        return Gemini::generativeModel("gemini-2.0-flash")->generateContent($detailsPrompt)->text();
    }
}