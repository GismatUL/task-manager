<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function store(array $data): Task
    {
        return Task::create([
            'name' => $data['name'],
            'project_id' => $data['project_id'],
        ]);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update([
            'name' => $data['name'],
            'project_id' => $data['project_id'],
        ]);
    }


    public function updateTaskOrder(array $orderData): void
    {
        foreach ($orderData as $index => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $index + 1]);
        }
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

}
