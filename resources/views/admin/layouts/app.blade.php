<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Админ панель</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #495057;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
        }
        .table-actions {
            white-space: nowrap;
            width: 1%;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        .gallery-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin: 5px;
            border-radius: 4px;
            position: relative;
        }
        .gallery-image .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .gallery-image:hover .delete-btn {
            opacity: 1;
        }
        .characteristics-item {
            margin-bottom: 10px;
        }
    </style>
    @stack('styles')
</head>
<body>
<!-- Навбар -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Админ панель
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/" target="_blank">
                        <i class="bi bi-eye"></i> Посмотреть сайт
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name ?? 'Администратор' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i> Выйти
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Сайдбар -->
        <div class="col-md-3 col-lg-2 sidebar d-md-block">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Дашборд
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                           href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box"></i> Товары
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-tags"></i> Категории
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-cart"></i> Заказы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-people"></i> Пользователи
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Основной контент -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Автоматическое скрытие алертов через 5 секунд
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);

    // Динамическое добавление характеристик
    function addCharacteristic() {
        const container = document.getElementById('characteristics-container');
        const index = container.children.length;
        const html = `
                <div class="characteristics-item row g-2" id="char-${index}">
                    <div class="col-md-5">
                        <input type="text" name="characteristics[${index}][key]"
                               class="form-control" placeholder="Название характеристики" required>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="characteristics[${index}][value]"
                               class="form-control" placeholder="Значение" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger w-100"
                                onclick="removeCharacteristic(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function removeCharacteristic(index) {
        const element = document.getElementById(`char-${index}`);
        if (element) {
            element.remove();
        }
    }

    // Предпросмотр изображения
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
            preview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }

    // Удаление изображения из галереи
    function deleteGalleryImage(productId, imageIndex) {
        if (confirm('Удалить это изображение?')) {
            $.ajax({
                url: `/admin/products/${productId}/delete-gallery-image`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    image_index: imageIndex
                },
                success: function(response) {
                    if (response.success) {
                        $(`#gallery-image-${imageIndex}`).remove();
                    }
                }
            });
        }
    }
</script>
@stack('scripts')
</body>
</html>
