<ul id="main-sidebar">
    <li class="sidebar-item mb-4"><a class="color-" href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
    <li class="sidebar-item">
        <a class="color-sidebar" href="#">Quản lý tài khoản</a>
        <ul class="sidebar-list">
            <li class="sidebar-link color-sidebar"><a class="color-sidebar" href="{{ route('users.form') }}">Tạo tài khoản</a></li>
            <li class="sidebar-link"><a class="color-sidebar" href="{{ route('users.index') }}">Danh sách tài khoản</a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="color-sidebar" href="#">Quản lý danh mục fiml</a>
        <ul class="sidebar-list">
            <li class="sidebar-link color-sidebar"><a class="color-sidebar" href="{{ route('categories.form') }}">Thêm danh mục film</a></li>
            <li class="sidebar-link"><a class="color-sidebar" href="{{ route('categories.index') }}">Danh sách danh mục film</a></li>
        </ul>
    </li>
</ul>

