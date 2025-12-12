<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Админка</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0">
            <div class="sidebar">
                <div class="p-3">
                    <h5 class="text-white mb-4">
                        <a class="fas fa-cog"></a> Админ панель
                    </h5>

                    <div class="nav flex-column">
                        <div class="nav-item">
                            <div class="nav-link {{ request()->is('admin') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                <a class="fas fa-tachometer-alt"></a> Дашборд
                            </div>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
                               href="{{ route('admin.products.index') }}">
                                <b class="fas fa-box">Товары</b>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link" href="#">
                                <b class="fas fa-shopping-cart">Заказы</b>
                            </a>
                        </div>
                        

                        <div class="nav-item mt-4">
                            <div class="nav-link" href="{{ route('welcome') }}" target="_blank">
                                <a class="fas fa-external-link-alt">На сайт</a>
                            </div>
                        </div>

                        <div class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100">
                                    <a class="fas fa-sign-out-alt"></a> Выйти
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <!-- Top Navigation -->
            <nav class="navbar navbar-light bg-white border-bottom py-3">
                <div class="container-fluid">
                        <span class="navbar-brand mb-0">
                            <a class="fas fa-user-shield text-primary"></a>

                        </span>
                </div>
            </nav>

            <!-- Content -->
            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</div>

</body>
</html>
