@extends('admins.layouts.master')
@section("style")
    <style>
        table.dataTable.no-footer {
            border: 1px solid rgba(0, 0, 0, 0.3);
            margin-top: 40px;
        }
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <div class="row mb-4">
        <div class="col-4">
            <label for="">Tên tài khoản</label>
            <input type="text" name="user_name" id="user_name" class="form-control">
        </div>
        <div class="col-4">
            <label for="">Email</label>
            <input type="text" name="email" id="email" class="form-control">
        </div>
        <div class="col-4">
            <label for="">Quyền</label>
            <select name="role_id" id="role_id" class="form-control">
                <option value="">Tất cả</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <label for="">Ngày tạo tài khoản từ</label>
            <input name="start_date" type="datetime-local" id="start_date" class="form-control">
        </div>
        <div class="col-4">
            <label for="">đến ngày</label>
            <input name="end_date" type="datetime-local" id="end_date" class="form-control">
        </div>
    </div>
    <div class="row m-4">
        <div class="col-3">
            <button class="btn btn-success btn-sm me-2" id="search-user">Tìm kiếm</button>
            <button class="btn btn-primary btn-sm" id="reset-search-user">Làm mới</button>
        </div>
    </div>
    <div class="row">
        <table id="myTableUser" class="display">
            <thead>
            <tr>
                <th>Id</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Quyền</th>
                <th>Ngày tạo</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    <script>
        let tableUser = $('#myTableUser').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [3, 5],
            "oLanguage": {
                "sLengthMenu": "Hiển thị _MENU_ dữ liệu trên trang",
                "sZeroRecords": "Không có dữ liệu",
                "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ dữ liệu ",
                "sInfoEmpty": "Không có dữ liệu",
                "sInfoFiltered": "(được lọc from _MAX_ total records)",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Sau",
                    "sPrevious": "Trước"
                },
            },

            ajax: {
                url: '{{ route('users.list') }}',
                data: function (d) {
                    d.user_name = $('#user_name').val();
                    d.email = $('#email').val();
                    d.role_id = $('#role_id').find(':selected').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                {
                    data: 'id', ordering: true,
                    render: function (colValue, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'first_name',
                    render: function (colValue, type, row) {
                        return `${row.first_name} ${row.last_name}`;
                    }
                },
                {data: 'email'},
                {data: 'phone'},
                {
                    data: 'roles',
                    render: function (colValue, type, row) {
                        let resultHTML = '<ul>';
                        if (row?.roles?.length > 0) {
                            row.roles.map(function (role) {
                                resultHTML += `<li>${role.name}</li>`
                            })
                        }
                        resultHTML += '</ul>';

                        return resultHTML;
                    }
                },
                {
                    data: 'created_at',
                    render: function (colValue) {
                        const today = new Date(colValue);
                        const yyyy = today.getFullYear();
                        let mm = today.getMonth() + 1; // Months start at 0!
                        let dd = today.getDate();
                        if (dd < 10) {
                            dd = '0' + dd
                        }
                        if (mm < 10) {
                            mm = '0' + mm
                        }
                        const formattedToday = dd + '/' + mm + '/' + yyyy;

                        return formattedToday
                    }
                },
                {
                    data: 'id', orderable: false,
                    render: function (colValue, type, row) {
                        let deleteUrl = '{{ route('users.delete', ':id') }}';
                        deleteUrl = deleteUrl.replace(':id', colValue);

                        let editUrl = '{{ route('users.edit', ':id') }}';
                        editUrl = editUrl.replace(':id', colValue);
                        let resultHtml = '<div class="actions">';
                        if (row?.roles?.length > 0) {
                            row.roles.map(function (role) {
                                if (role.slug !== 'super-admin') {
                                    resultHtml += `<a class="btn btn-warning btn-sm" href="${editUrl}">Sửa</a>
                                                    <a class="btn btn-danger btn-sm" onclick="return confirm('Bạn muốn xóa tài khoản này?')"
                                                           href="${deleteUrl}">Xóa
                                                    </a>`
                                }
                            })
                        }
                        resultHtml += '</div>';

                        return resultHtml;
                    }
                },

            ],
        });

        $('#search-user').on('click', function () {
            tableUser.draw();
        });
        $('#reset-search-user').on('click', function () {
            $('#user_name').val('');
            $('#email').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            tableUser.draw();
        })
    </script>
@endsection
