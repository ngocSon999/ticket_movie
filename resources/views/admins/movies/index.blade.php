@extends('admins.layouts.master')
@section('title', 'Danh sách phim')
@section("style")
    <style>

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-4">
            <label for="">Tên phim</label>
            <input type="text" name="name" id="movie_name" class="form-control">
        </div>
        <div class="col-4">
            <label for="">Ngày bắt đầu chiếu</label>
            <input name="start_date" type="datetime-local" id="start_date" class="form-control">
        </div>
        <div class="col-4">
            <label for="">Ngày kết thúc</label>
            <input name="end_date" type="datetime-local" id="end_date" class="form-control">
        </div>
    </div>
    <div class="row mt-4 mb-4 justify-content-center">
        <div class="col-4">
            <button class="btn btn-success btn-sm me-2" id="search-movie">Tìm kiếm</button>
            <button class="btn btn-primary btn-sm" id="reset-search-movie">Làm mới</button>
        </div>
    </div>
    <div class="row mt-4">
        <table id="my-table-movie" style="width: 100%">
            <thead>
            <tr>
                <th>STT</th>
                <th>Tên phim</th>
                <th>Mô tả</th>
                <th>Banner</th>
                <th>Slide</th>
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
        $.fn.dataTable.ext.errMode = 'throw';
        let tableMovie = $('#my-table-movie').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [10, 25, 50],
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
                url: '{{ route('admin.movies.list') }}',
                data: function (d) {
                    d.movie_name = $('#movie_name').val();
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
                {data: 'name'},
                {data: 'description'},
                {
                    data: 'banner',
                    render: function (colValue) {
                        let path = '{{ asset(':colValue') }}'
                        path = path.replace(':colValue', colValue);
                        return `<img src="${path}" alt="" width="100" height="100">`;
                    }
                },
                {
                    data: 'add_to_slide',
                    render: function (colValue, type, row) {
                        let html = '';
                        if (colValue === 1) {
                            html = `<input class="add-to-slide" data-movie_id="${row.id}" style="width: 20px; height: 20px" type="checkbox" checked value="${colValue}">`
                        } else {
                            html = `<input class="add-to-slide" data-movie_id="${row.id}" style="width: 20px; height: 20px" type="checkbox" value="${colValue}">`
                        }

                        return html;
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
                        return dd + '/' + mm + '/' + yyyy
                    }
                },
                {
                    data: 'id', orderable: false,
                    render: function (colValue, type, row) {
                        let deleteUrl = '{{ route('admin.movies.delete', ':id') }}';
                        deleteUrl = deleteUrl.replace(':id', colValue);

                        let editUrl = '{{ route('admin.movies.edit', ':id') }}';
                        editUrl = editUrl.replace(':id', colValue);

                        let resultHtml = `<a class="btn btn-warning btn-sm" href="${editUrl}">Sửa</a>
                                                    <a class="btn btn-danger btn-sm" onclick="return confirm('Bạn muốn xóa tài khoản này?')"
                                                           href="${deleteUrl}">Xóa
                                                    </a>`
                        return resultHtml;
                    }
                },
            ],
        });

        $('#search-movie').on('click', function () {
            tableMovie.draw();
        });
        $('#reset-search-movie').on('click', function () {
            $('#movie_name').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            tableMovie.draw();
        })

        $(document).on('click', '.add-to-slide', function () {
            let selectToSide = $(this).val();
            let selectValue = null;
            if (selectToSide == 1) {
                alert('remove movie to slide?')
                selectValue = 0
            }
            if (selectToSide == 0) {
                alert('add movie to slide?')
                selectValue = 1
            }
            $.ajax({
                url: '{{ route('web.movie.add-to-slide') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    id: $(this).data('movie_id'),
                    selectValue:selectValue
                },
                success: function (res) {
                    if (res.code === 0) {
                        alert(res.message)
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000)
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        });
    </script>
@endsection
