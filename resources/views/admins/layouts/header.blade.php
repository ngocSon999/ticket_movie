<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('admin.dashboard') }}">Home</a>
    </li>
    @if(!Sentinel::getUser())
        <li class="nav-item">
            <a class="dropdown-item" href="{{ route('admin.user.login') }}">Đăng nhập</a>
        </li>
    @else
        <li class="nav-item">
            <a class="dropdown-item" href="{{ route('admin.user.logout') }}">Đăng xuất</a>
        </li>
    @endif

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Dropdown</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
    </li>
</ul>
