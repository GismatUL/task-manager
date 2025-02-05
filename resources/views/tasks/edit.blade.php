@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Task List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Task</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Task</h4>
            </div>
            <div class="card-body">
                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops! Something went wrong.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Task Form -->
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Use PUT method for updating -->

                    <!-- Task Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Task Name</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $task->name) }}" placeholder="Enter task name" required>
                        @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Project Selection -->
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Select Project</label>
                        <select name="project_id" id="project_id"
                                class="form-control @error('project_id') is-invalid @enderror" required>
                            <option value="" disabled>-- Choose a Project --</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
