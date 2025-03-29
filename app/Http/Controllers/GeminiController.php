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
           
            設定したタスクについて詳細を各タスクにつき3つづつ出力してください
            タスクごとに""で囲ってください
            内容は?で囲ってください
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

            $Matchesname = [];
            $Matchesdescription = [];
            $Matchesurl = [];
            preg_match_all('/"(.*?)"/', $response, $Matchesname);
            preg_match_all('/\?(.*?)\?/', $response1, $Matchesdescription);
            preg_match_all('/"(.*?)"/', $response2, $Matchesurl);
            $Tasknames = $Matchesname[1]; // 抽出された文字列の配列
            $Taskdescription = $Matchesdescription[1]; // 抽出された文字列の配列
            $Taskurl = $Matchesurl[1]; // 抽出された文字列の配列
         
            Log::info('Extracted Task URLs:', ['Taskurl' => $Taskurl]);

            return view('ask', compact('Tasknames','Taskurl','Taskdescription'));
        }
    }
