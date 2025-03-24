<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\DomCrawler\Crawler;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'url',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function fetchTitle()
    {
        $client = new Client();

        // URL の形式を検証
        
        try {
            $response = $client->get($this->link); // 指定された URL に対して HTTP GET リクエストを送信
            $html = $response->getBody()->getContents(); // レスポンスのボディを文字列として取得

            $crawler = new Crawler($html);
            $title = $crawler->filter('title')->first()->text(); // HTML からタイトルを抽出

            return $title;
        } catch (ConnectException $e) {
            // DNS 解決エラーなどの接続エラーを処理
            \Log::error('ConnectException: ' . $e->getMessage());
            return 'ホストを解決できません';
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() == 404) {
                return 'ページが見つかりません';
            }
            // その他のリクエストエラーを処理
            \Log::error('RequestException: ' . $e->getMessage());
            return '表示できません';
        } catch (\Exception $e) {
            // その他の一般的なエラーを処理
            \Log::error('Exception: ' . $e->getMessage());
            return '表示できません';
        }
    }
}
