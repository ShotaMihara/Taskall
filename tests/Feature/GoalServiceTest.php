<?php

namespace Tests\Feature;

use App\Models\Goal;
use App\Models\Task;
use App\Models\User;
use App\Services\GoalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoalServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $goalService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->goalService = app(GoalService::class);
    }

    /** @test */
    public function it_can_get_goals_for_user()
    {
        // Arrange: ユーザーとゴールを作成
        $user = User::factory()->create();
        $goal = Goal::factory()->create(['user_id' => $user->id]);
        Task::factory()->count(3)->create(['goal_id' => $goal->id, 'status' => 1]);

        // Act: ゴールを取得
        $goals = $this->goalService->getGoalsForUser($user->id);

        // Assert: ゴールが取得され、進捗度が計算されていることを確認
        $this->assertCount(1, $goals);
        $this->assertEquals(100, $goals->first()->progress);
    }

    /** @test */
    public function it_can_get_goal_with_details()
    {
        // Arrange: ゴールと関連データを作成
        $goal = Goal::factory()->create();
        Task::factory()->count(2)->create(['goal_id' => $goal->id, 'status' => 1]);
        Task::factory()->count(1)->create(['goal_id' => $goal->id, 'status' => 0]);

        // Act: ゴールの詳細を取得
        $retrievedGoal = $this->goalService->getGoalWithDetails($goal->id);

        // Assert: ゴールと関連データが取得され、進捗度が計算されていることを確認
        $this->assertEquals(66.67, $retrievedGoal->progress);
        $this->assertCount(3, $retrievedGoal->tasks);
    }

    /** @test */
    public function it_can_delete_goal_by_id()
    {
        // Arrange: ゴールを作成
        $goal = Goal::factory()->create();

        // Act: ゴールを削除
        $this->goalService->deleteGoalById($goal->id);

        // Assert: ゴールが削除されていることを確認
        $this->assertDatabaseMissing('goals', ['id' => $goal->id]);
    }

    /** @test */
    public function it_can_calculate_progress()
    {
        // Arrange: ゴールとタスクを作成
        $goal = Goal::factory()->create();
        Task::factory()->count(3)->create(['goal_id' => $goal->id, 'status' => 1]);
        Task::factory()->count(2)->create(['goal_id' => $goal->id, 'status' => 0]);

        // Act: 進捗度を計算
        $this->goalService->calculateProgress($goal);

        // Assert: 進捗度が正しく計算されていることを確認
        $this->assertEquals(60, $goal->fresh()->progress);
    }
}
