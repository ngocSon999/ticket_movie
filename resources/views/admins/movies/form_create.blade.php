@extends('admins.layouts.master')
@section('style')
@endsection
@section('content')
    @if(!empty($movie))
        <form class="mt-4" action="{{ route('admin.movies.update', ['id' => $movie->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @else
                <form class="mt-4" action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tên phim<span class="color-red">*</span></label>
                        <input type="text" maxlength="100" class="form-control" name="name"
                               value="{{ old('name') ?? !empty($movie->name) ? $movie->name : '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Mô tả<span class="color-red"></span></label>
                        <input type="text" maxlength="100" class="form-control" name="description"
                               value="{{ old('description') ?? !empty($movie->description) ? $movie->description : '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Thời gian bắt đầu chiếu<span class="color-red">*</span></label>
                        <input type="text" maxlength="15" class="form-control datepicker" name="start_date" id="start_date"
                               value="{{ old('start_date') ?? !empty($movie->start_date) ? $movie->start_date : '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Thời gian kết thúc<span class="color-red">*</span></label>
                        <input type="text" maxlength="15" class="form-control datepicker" name="end_date" id="end_date"
                               value="{{ old('end_date') ?? !empty($movie->end_date) ? $movie->end_date : '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">giới hạn độ tuổi<span class="color-red">*</span></label>
                        <input type="number" maxlength="2" class="form-control" name="age_limit"
                               value="{{ old('age_limit') ?? !empty($movie->age_limit) ? $movie->age_limit : '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Banner<span class="color-red">*</span></label>
                        <input type="file" class="form-control" name="banner"
                               value="{{ old('banner') ?? !empty($movie->banner) ? $movie->banner : '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Trailer<span class="color-red">*</span></label>
                        <input type="text" maxlength="255" class="form-control" name="trailer"
                               value="{{ old('trailer') ?? !empty($movie->trailer) ? $movie->trailer : '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Giám đốc sản xuất<span class="color-red">*</span></label>
                        <input type="text" maxlength="20" class="form-control" name="director_id"
                               value="{{ old('director_id') ?? !empty($movie->director_id) ? $movie->director_id : '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Xác nhận</button>
                </form>
        @endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Vietnamese translations for jQuery UI datepicker
            $.datepicker.setDefaults({
                dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
                dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                monthNames: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                // monthNamesShort: ["T1", "T2", "T3", "T4", "T5", "T6", "T7", "T8", "T9", "T10", "T11", "T12"],
                monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                today: "Hôm nay",
                clear: "Xóa",
                dateFormat: "mm/dd/yyyy",
                titleFormat: "MM yyyy",
                weekStart: 0,
            });

            // Initialize the datepicker
            $(".datepicker").datetimepicker({
                dateFormat: "dd-mm-yy",
                timeFormat: "HH:mm", // Time format (24-hour format)
                controlType: 'select',
                oneLine: true, // Display time dropdowns in one line
                changeMonth: true,
                changeYear: true,
                yearRange: "1900:{{ date('Y') }}",
                showButtonPanel: true,
                showAnim: "fadeIn",
                // numberOfMonths: 2,
                showOtherMonths: true,
                selectOtherMonths: true,
            });
        });
    </script>

        @endsection
