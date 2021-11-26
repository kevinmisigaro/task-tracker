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
<h1 class="h3 mb-2 text-gray-800">Employees</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
            Add new employee
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">
                            Add new employee
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/employees/store" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="">Full name</label>
                                <input type="text" autocomplete="off" name="name" class="form-control">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Email</label>
                                <input type="email" autocomplete="off" name="email" class="form-control">
                                <small>Their passwords will be '1234'. They should reset their passwords once logged in the first time</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Department</label>
                                <select name="department" class="form-control">
                                    <option value="" selected disabled>Select department</option>
                                    @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-success">
                                    Submit
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
                        <th>Name</th>
                        <th>Pending tasks</th>
                        <th>Inprogress tasks</th>
                        <th>Completed tasks</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Overdue tasks</th>
                        <th>Inprogress tasks</th>
                        <th>Completed tasks</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $employee->name }}
                        </td>
                        <td>
                            {{ count(\App\Models\Task::where([
                            'status' =>  2,
                            'user_id' => $employee->id
                            ])->get()) }}
                        </td>
                        <td>
                            {{ count(\App\Models\Task::where([
                            'status' =>  1,
                            'user_id' => $employee->id
                            ])->get()) }}
                        </td>
                        <td>
                            {{ count(\App\Models\Task::where([
                            'status' =>  3,
                            'user_id' => $employee->id
                            ])->get()) }}
                        </td>
                        <td>
                            <div class="dropright">
                                <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#updateModal{{ $employee->id }}">Update</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#deleteModal{{ $employee->id }}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $employee->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Delete {{ $employee->name }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center p-2">
          Are you sure you want to delete {{ $employee->name }} ?
          <br><br>
          <a href="/employees/delete/{{ $employee->id }}" class="btn btn-danger">
            Delete
          </a>
      </div>
    </div>
  </div>
</div>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal{{ $employee->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ $employee->name }} details
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/employees/update/{{ $employee->id }}" method="post">
                                        @csrf

                                        <div class="row mb-3">

                                            <div class="col-md-6">
                                                <label for="">Name</label>
                                                <input type="text" name="name" value="{{ $employee->name }}"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="">Email</label>
                                                <input type="text" name="email" value="{{ $employee->email }}"
                                                    class="form-control">
                                            </div>

                                        </div>

                                        <div class="form-group mb-3">
                                            <button class="btn btn-warning" type="submit">
                                                Update
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
        </div>
    </div>
</div>

@endcomponent
