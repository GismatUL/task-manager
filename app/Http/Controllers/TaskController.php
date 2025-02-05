<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request) :View
    {
        $projects = Project::select('id', 'name')->get();
        $query = Task::with('project');

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->orderBy('priority', 'asc')->get();
        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function create() :View
    {
        $projects = Project::select('id','name')->get();
        return view('tasks.create', compact('projects'));
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        $this->taskService->store($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function edit(Task $task): View
    {
        $projects = Project::select('id', 'name')->get();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        $this->taskService->update($task, $request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->taskService->delete($task);
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function updateOrder(Request $request)
    {
        $this->taskService->updateTaskOrder($request->order);
        return response()->json(['success' => true]);
    }



}
