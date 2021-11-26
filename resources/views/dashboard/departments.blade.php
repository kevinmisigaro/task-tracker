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
    <h1 class="h3 mb-2 text-gray-800">Departments</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
            Create department
        </button>

        <!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">
              Create new department
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/departments/store" method="post">
                @csrf
                <div class="form-group mb-4">
                    <label for="">Department name</label>
                    <input type="text" autocomplete="off" name="name" class="form-control">
                </div>
                
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-success">
                        Create department
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
                <th>Employees</th>
                <th></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Employees</th>
                <th></th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($departments as $department)
                  <tr>
                      <td>
                          {{ $loop->iteration }}
                      </td>
                      <td>
                          {{ $department->name }}
                      </td>
                      <td>
                          {{ $department->users_count }}
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