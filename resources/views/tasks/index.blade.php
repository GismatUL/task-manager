@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Task Manager</h2>
            <a href="{{ route('tasks.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Task
            </a>
        </div>
        <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="project_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- All Projects --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Task Name</th>
                    <th>Project</th>
                    <th>Priority</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="sortable">
                @forelse($tasks as $task)
                    <tr data-id="{{ $task->id }}" class="sortable-row">
                        <td><i class="fas fa-arrows-alt"></i></td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->project->name ?? 'N/A' }}</td>
                        <td class="priority-value">{{ $task->priority }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No tasks available.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $("#sortable").sortable({
                axis: "y",  // Only allow vertical dragging
                cursor: "grab",
                opacity: 0.7,
                placeholder: "sortable-placeholder",
                stop: function (event, ui) {
                    let order = [];
                    $("#sortable tr").each(function (index) {
                        let taskId = $(this).data("id");
                        order.push({ id: taskId, priority: index + 1 });
                        $(this).find(".priority-value").text(index + 1);
                    });

                    $.ajax({
                        url: "{{ route('tasks.updateOrder') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function (response) {
                            console.log("Order updated successfully!", response);
                        },
                        error: function (xhr) {
                            console.error("Error updating order", xhr);
                        }
                    });
                }
            });
        });

    </script>
@endsection
