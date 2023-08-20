@extends('admins.layouts.master')
@section('style')
@endsection
@section('content')
    @if(!empty($movie))
        <form class="mt-4" action="{{ route('admin.movies.update', ['id' => $movie->id]) }}" method="POST"
              enctype="multipart/form-data">
            @method('PUT')
            @else
                <form class="mt-4" action="{{ route('admin.movies.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Danh mục phim<span
                                class="color-red">*</span></label>
                        <select class="form-control" name="category_id[]" id="">
                            <option value="">Chọn danh mục phim</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                @if(!empty($movie) && $movie->categories->contains($category->id))
                                    selected
                                @endif
                                >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tên phim<span
                                class="color-red">*</span></label>
                        <input type="text" maxlength="100" class="form-control" name="name"
                               @if(!empty($movie))
                                   value="{{ old('name') ?? $movie->name }}"
                               @else
                                   value="{{ old('name') }}"
                            @endif
                        >
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Mô tả<span class="color-red"></span></label>
                        <input type="text" maxlength="100" class="form-control" name="description"
                               @if(!empty($movie))
                                   value="{{ old('description') ?? $movie->description }}"
                               @else
                                   value="{{ old('description') }}"
                            @endif
                        >
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Thời gian bắt đầu chiếu<span
                                class="color-red">*</span></label>
                        <input type="text" maxlength="15" class="form-control datepicker" name="start_date"
                               id="start_date"
                               @if(!empty($movie))
                                   value="{{ old('start_date') ?? $movie->start_date }}"
                               @else
                                   value="{{ old('start_date') }}"
                            @endif
                        >
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Thời gian kết thúc<span
                                class="color-red">*</span></label>
                        <input type="text" maxlength="15" class="form-control datepicker" name="end_date" id="end_date"
                               @if(!empty($movie))
                                   value="{{ old('end_date') ?? $movie->end_date }}"
                               @else
                                   value="{{ old('end_date') }}"
                            @endif
                        >
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">giới hạn độ tuổi<span
                                class="color-red">*</span></label>
                        <input type="number" maxlength="2" class="form-control" name="age_limit"
                               @if(!empty($movie))
                                   value="{{ old('age_limit') ?? $movie->age_limit }}"
                               @else
                                   value="{{ old('age_limit') }}"
                            @endif
                        >
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Banner
                            <span class="color-red">*</span>
                        </label>
                        <input type="file" class="form-control" name="banner"
                               @if(!empty($movie))
                                   value="{{ old('banner') ?? $movie->banner }}"
                               @else
                                   value="{{ old('banner') }}"
                            @endif
                        >
                        @if(!empty($movie))
                            <img src="{{ asset($movie->banner) }}" alt="" width="200" height="200">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Trailer<span
                                class="color-red">*</span></label>
                        <input type="text" class="form-control" name="trailer"
                               @if(!empty($movie))
                                   value="{{ old('trailer') ?? $movie->trailer }}"
                               @else
                                   value="{{ old('trailer') }}"
                            @endif
                        >
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Giám đốc sản xuất<span
                                class="color-red">*</span></label>
                        <input type="text" maxlength="20" class="form-control" name="director_id"
                               @if(!empty($movie))
                                   value="{{ old('director_id') ?? $movie->director_id }}"
                               @else
                                   value="{{ old('director_id') }}"
                            @endif
                        >
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Xác nhận</button>
                </form>
                @endsection
                @section('js')
                    <script>
                        $(document).ready(function () {
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
                                // numberOfMonths: 10,
                                showOtherMonths: true,
                                selectOtherMonths: true,
                            });
                        });
                    </script>

        @endsection
