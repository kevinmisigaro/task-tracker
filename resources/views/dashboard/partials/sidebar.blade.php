@if (\Illuminate\Support\Facades\Auth::user()->role == 1)
<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="/employees">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Employees</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/departments">
        <i class="fas fa-fw fa-table"></i>
        <span>Departments</span></a>
</li>
@endif

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/tasks">
        <i class="fas fa-fw fa-table"></i>
        <span>Tasks</span></a>
</li>
