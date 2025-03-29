<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    public function askQuestion(Request $request)
    {
        $prompt = $request->input('question');
        $goal = <<<EOD
    
            #目標{$prompt}を達成するまでのタスクを作成してください。
            箇条書きで記入してください。
            最大で15件まで記入可能です。
            Phase などは必要ありません
            項目ごとに""で囲ってください
            (例)
            1. "タスク1"
            2. "タスク2"
            EOD;
            $response = Gemini::generativeModel("gemini-2.0-flash")->generateContent($goal)->text();

        $goal1 = <<<EOD
           
            設定したタスクについてタスク毎に詳細を教えてください
            タスクの詳細には以下の項目を含めてください
            タスク名は""で囲ってください
            内容は''で囲ってください
            (例)
            "タスク"
                '目的:'
                'アクション:'
            {$response}
            EOD;
            
            $response1 = Gemini::generativeModel("gemini-2.0-flash")->generateContent($goal1)->text();

        $goal2 = <<<EOD
            参考になるyoutybeやブログのリンクを教えてください
            URLのみ出力してください
            URLごとに""で囲ってください
            {$response}
            EOD;

            $response2 = Gemini::generativeModel("gemini-2.0-flash")->generateContent($goal2)->text();
            return view('ask', compact('response', 'response1', 'response2'));
        }
    }
