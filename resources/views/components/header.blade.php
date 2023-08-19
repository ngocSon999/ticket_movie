<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('web.index') }}">
                <img src="{{ asset('asset/image/logo.jpg') }}" width="80px" height="40px" alt="">
                Ahihi
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.index') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="menuDrop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Danh mục phim
                        </a>
{{--                        <ul id="menu-category" style="display: none">--}}
                        <ul id="menu-category" class="dropdown-menu menu-category" aria-labelledby="menuDrop">
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="#">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="movieTheater" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Rạp CGV
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="movieTheater">
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="#">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

