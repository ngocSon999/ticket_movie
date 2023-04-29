@extends('admins.layouts.master')
@section("style")
    <style>
        table.dataTable.no-footer {
            border: 1px solid rgba(0, 0, 0, 0.3);
            margin-top: 40px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Lats Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Quyền</th>
                <th>Ngày tạo</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('js')
    <script>
        var userTable = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "language": {
                "lengthMenu": "Hiển thị _MENU_ sản phẩm trên trang",
                "zeroRecords": "Không có kết quả",
                "sSearch": "Tìm kiếm",
                "sInfo": "Hiển thị _START_ đến _END_ trên _TOTAL_ kết quả",
                "infoEmpty": "Không có dữ liệu",
                "infoFiltered": "",
                "Osearch": "Tìm kiếm",
                searchPlaceholder: "Nhập từ tìm kiếm",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Sau",
                    "sPrevious": "Trước"
                },
            },

            ajax: {
                method: 'GET',
                url: '{{ route('users.list') }}',
            },
            columns: [
                { data: 'id', name: 'id'},
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'role', name: 'role' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    </script>
@endsection
