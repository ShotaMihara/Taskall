<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Goal;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $taskService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskService = app(TaskService::class);
    }

    #[Test]
    public function testItCanUpdateATask()
    {
        // Arrange: ユーザー、ゴール、タスクを作成
        $user = User::factory()->create();
        $goal = Goal::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create([
            'goal_id' => $goal->id,
            'name' => 'Old Task Name',
            'description' => 'Old Description',
        ]);

        $data = [
            'name' => 'Updated Task Name',
            'description' => 'Updated Description',
        ];

        // Act: タスクを更新
        $this->taskService->updateTask($task, $data);

        // Assert: データベースに変更が反映されていることを確認
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task Name',
            'description' => 'Updated Description',
        ]);
    }

    public function testItCanDeleteATask()
    {
        // Arrange: タスクを作成
        $task = Task::factory()->create();

        // Act: タスクを削除
        $this->taskService->deleteTask($task);

        // Assert: データベースから削除されていることを確認
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function testItCanToggleTaskStatus()
    {
        // Arrange: タスクを作成
        $task = Task::factory()->create([
            'status' => false, // 初期状態を false に設定
        ]);

        // Act: タスクの状態を切り替え
        $this->taskService->toggleTaskStatus($task);
        $task->refresh(); // 最新の状態を取得

        // Assert: 状態が true に切り替わっていることを確認
        $this->assertTrue($task->status);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 1,
        ]);

        // 再度切り替え
        $this->taskService->toggleTaskStatus($task);
        $task->refresh(); // 最新の状態を取得

        // Assert: 状態が false に戻っていることを確認
        $this->assertFalse($task->status);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 0,
        ]);
    }
}
