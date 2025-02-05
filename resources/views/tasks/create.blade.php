@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Task List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Task</li>
            </ol>
        </nav>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Create New Task</h4>
            </div>
            <div class="card-body">
                <!-- Display Validation Errors -->

                <!-- Task Form -->
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    <!-- Task Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Task Name</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Enter task name" required>
                        @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Project Selection -->
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Select Project</label>
                        <select name="project_id" id="project_id"
                                class="form-control @error('project_id') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Choose a Project --</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i> Add Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
