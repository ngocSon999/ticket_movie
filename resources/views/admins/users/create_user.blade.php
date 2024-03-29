@extends('admins.layouts.master')
@section('style')
@endsection
@section('content')
    @if(!empty($user))
        <form class="mt-4" action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST">
            @method('PUT')
            @else
                <form class="mt-4" action="{{ route('admin.users.create') }}" method="POST">
                    @endif
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">First name <span class="color-red">*</span></label>
                        @if(!empty($user))
                            <input type="text" maxlength="100" class="form-control" name="first_name"
                                   value="{{ old('first_name') ?? $user->first_name}}">
                        @else
                            <input type="text" maxlength="100" class="form-control" name="first_name" value="{{ old('first_name') }}">
                        @endif
                        @if ($errors->has('first_name'))
                            @foreach ($errors->get('first_name') as $error)
                                <p class="form-message">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Last name <span class="color-red">*</span></label>
                        @if(!empty($user))
                            <input type="text" maxlength="100" class="form-control" name="last_name"
                                   value="{{ old('last_name') ?? $user->last_name }}">
                        @else
                            <input type="text" maxlength="100" class="form-control" name="last_name" value="{{ old('last_name') }}">
                        @endif
                        @if ($errors->has('last_name'))
                            @foreach ($errors->get('last_name') as $error)
                                <p class="form-message">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email <span class="color-red">*</span></label>
                        @if(!empty($user))
                            <input type="email" maxlength="150" class="form-control" name="email"
                                   value="{{ old('email') ?? $user->email }}">
                        @else
                            <input type="email" maxlength="150" class="form-control" name="email" value="{{ old('email') }}">
                        @endif
                        @if ($errors->has('email'))
                            @foreach ($errors->get('email') as $error)
                                <p class="form-message">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Phone <span class="color-red">*</span></label>
                        @if(!empty($user))
                            <input type="text" maxlength="11" class="form-control" name="phone"
                                   value="{{ old('phone') ?? $user->phone }}">
                        @else
                            <input type="text" maxlength="11" class="form-control" name="phone" value="{{ old('phone') }}">
                        @endif
                        @if ($errors->has('phone'))
                            @foreach ($errors->get('phone') as $error)
                                <p class="form-message">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password
                            @if(empty($user))
                                <span class="color-red">*</span>
                            @endif
                        </label>
                        <input type="password" class="form-control" name="password">
                        @if ($errors->has('password'))
                            @foreach ($errors->get('password') as $error)
                                <p class="form-message">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Chọn quyền <span class="color-red">*</span></label>
                        <select class="form-control" name="role" id="">
                            @if(!empty($user))
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->roles[0]->id == $role->id ? 'selected' : '' }}
                                    >{{ $role->name }}</option>
                                @endforeach
                            @else
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role') == $role->id ? 'selected' : '' }}
                                    >{{ $role->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('role'))
                            @foreach ($errors->get('role') as $error)
                                <p class="form-message">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Xác nhận</button>
                </form>
        @endsection
