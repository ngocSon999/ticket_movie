    <a class="btn btn-info btn-sm" href="">Xem</a>
    @if(Sentinel::check())
        @if(Sentinel::inRole('super-admin'))
        <a class="btn btn-warning btn-sm" href="{{ route('users.edit', ['id' => $row->id]) }}">Sửa</a>
        <a class="btn btn-danger btn-sm" onclick="return confirm('Bạn muốn xóa tài khoản này?')"
           href="{{ route('users.delete', ['id' => $row->id]) }}">Xóa</a>
        @endif
    @endif
