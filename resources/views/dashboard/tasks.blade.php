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
        @if (\Illuminate\Support\Facades\Auth::user()->role == 1)
        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
            Create task
        </button>
        @endif

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
            @if (\Illuminate\Support\Facades\Auth::user()->role == 1)
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Task</th>
                        <th>Assigned person</th>
                        <th>Status</th>
                        <th>End date</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Task</th>
                        <th>Assigned person</th>
                        <th>Status</th>
                        <th>End date</th>
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
                        <td>
                            {{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}
                        </td>
                        <td>
                            <div class="dropright">
                                <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#managerViewModal{{ $task->id }}">Details</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#complete{{ $task->id }}Modal">Review task</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Manager View Modal -->
                    <div class="modal fade" id="managerViewModal{{ $task->id }}" tabindex="-1"
                        aria-labelledby="taskModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ $task->task_name }} task
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Start date</label>
                                            <input type="text" disabled class="form-control"
                                                value=" {{ \Carbon\Carbon::parse($task->start_date)->toFormattedDateString() }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">End date</label>
                                            <input type="text" disabled
                                                value=" {{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="">Employee report</label>
                                            <textarea class="form-control" disabled cols="100%" rows="5">
                                                {{ $task->report }}
                                            </textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="">Comment</label>
                                            <textarea class="form-control" disabled cols="100%" rows="5">
                                                {{ $task->comment }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Review task Modal -->
                    <div class="modal fade" id="review{{ $task->id }}Modal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ $task->task_name }} task review
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/tasks/review" method="post">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="">Report</label>
                                            <textarea disabled class="form-control" cols="100%" rows="5">
                                            {{ $task->report }}
                                            </textarea>
                                        </div>
                                        <input type="hidden" name="task" value="{{ $task->id }}">
                                        <div class="form-group mb-3">
                                            <label for="">Comment</label>
                                            <textarea name="comment" cols="100%" rows="6"
                                                class="form-control"></textarea>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <select name="type" class="form-control">
                                                    <option value="1">Accept task completion</option>
                                                    <option value="2">Reject task completion</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <small>Only add date if task completion is rejected and new date needs
                                                    to be set</small>
                                                <input type="date" name="newdate" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <button class="btn-success btn" type="submit">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    @endforeach
                </tbody>
            </table>
            @else
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>End date</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>End date</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach (\App\Models\Task::where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get() as
                    $task)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $task->task_name }}
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
                        <td>
                            {{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}
                        </td>
                        <td>
                            <div class="dropright">
                                <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#viewModal{{ $task->id }}">Details</a>
                                    @if ( $task->status != 3)
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#complete{{ $task->id }}Modal">Complete task</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- View Modal -->
                    <div class="modal fade" id="viewModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ $task->task_name }} task
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Start date</label>
                                            <input type="text" disabled class="form-control"
                                                value=" {{ \Carbon\Carbon::parse($task->start_date)->toFormattedDateString() }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">End date</label>
                                            <input type="text" disabled
                                                value=" {{ \Carbon\Carbon::parse($task->end_date)->toFormattedDateString() }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="">Comment</label>
                                            <textarea class="form-control" disabled cols="100%" rows="5">
                                                {{ $task->comment }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Task complete Modal -->
                    <div class="modal fade" id="complete{{ $task->id }}Modal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ $task->task_name }} task
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/tasks/submit" method="post">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="">Report</label>
                                            <textarea name="report" class="form-control" cols="100%"
                                                rows="5"></textarea>
                                        </div>
                                        <input type="hidden" name="task" value="{{ $task->id }}">
                                        <div class="form-group mb-3">
                                            <button class="btn-success btn" type="submit">
                                                Complete task
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

@endcomponent
