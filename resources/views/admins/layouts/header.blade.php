<ul class="nav nav-tabs justify-content-space-between">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('admin.dashboard') }}">Home</a>
    </li>
    <div id="header-profile">
        @if(!Sentinel::getUser())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user.login') }}">Đăng nhập</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user.logout') }}">Đăng xuất</a>
            </li>
        @endif
    </div>

</ul>
