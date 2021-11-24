@component('layout')

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tasks</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
            Create task
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">
                            Create new task
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/tasks/store" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="">Task name</label>
                                <input type="text" autocomplete="off" name="name" class="form-control">
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="">Start date</label>
                                    <input type="date" name="startdate" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="">End date</label>
                                    <input type="date" name="enddate" class="form-control">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Employee assigned</label>
                                <select name="employee" class="form-control">
                                    <option value="" selected disabled>Select employee</option>
                                    @foreach ($employees as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-success">
                                    Create task
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Task</th>
                        <th>Assigned person</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Task</th>
                        <th>Assigned person</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $task->task_name }}
                        </td>
                        <td>
                            {{ $task->user->name }}
                        </td>
                        <td>
                            @if ($task->status == 1)
                            <span class="badge badge-pill badge-info p-2">
                                In progress
                            </span>
                            @endif

                            @if ($task->status == 2)
                            <span class="badge badge-pill badge-danger p-2">
                                Overdue
                            </span>
                            @endif

                            @if ($task->status == 3)
                            <span class="badge badge-pill badge-success p-2">
                                Complete
                            </span>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endcomponent
