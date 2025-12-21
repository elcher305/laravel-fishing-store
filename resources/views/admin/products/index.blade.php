@extends('layouts.app')

@section('title', 'Управление товарами')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Товары</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Добавить товар
            </a>
        </div>
    </div>

    <!-- Фильтры и поиск -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control"
                           placeholder="Поиск по названию, SKU или описанию..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Все статусы</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Активные</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Неактивные</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Нет в наличии</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Рекомендуемые</option>
                        <option value="deleted" {{ request('status') == 'deleted' ? 'selected' : '' }}>Удаленные</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i> Применить фильтры
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Таблица товаров -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>SKU</th>
                        <th>Цена</th>
                        <th>Наличие</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th class="table-actions">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr class="{{ $product->trashed() ? 'table-danger' : '' }}">
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="product-image">
                                @else
                                    <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark ms-1">
                                    <i class="bi bi-star"></i> Рекомендуемый
                                </span>
                                @endif
                                @if($product->trashed())
                                    <span class="badge bg-danger ms-1">
                                    <i class="bi bi-trash"></i> Удален
                                </span>
                                @endif
                            </td>
                            <td><code>{{ $product->sku }}</code></td>
                            <td>
                                <strong>{{ $product->formatted_price }}</strong>
                                @if($product->has_discount)
                                    <br>
                                    <small class="text-muted text-decoration-line-through">
                                        {{ number_format($product->old_price, 2, '.', ' ') }} ₽
                                    </small>
                                    <span class="badge bg-success">
                                    -{{ $product->discount_percent }}%
                                </span>
                                @endif
                            </td>
                            <td>
                                @if($product->stock > 10)
                                    <span class="badge bg-success">
                                    {{ $product->stock }} шт.
                                </span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning">
                                    {{ $product->stock }} шт.
                                </span>
                                @else
                                    <span class="badge bg-danger">
                                    Нет в наличии
                                </span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Активен
                                </span>
                                @else
                                    <span class="badge bg-secondary">
                                    <i class="bi bi-x-circle"></i> Неактивен
                                </span>
                                @endif
                            </td>
                            <td>
                                <small>
                                    {{ $product->created_at->format('d.m.Y') }}<br>
                                    <span class="text-muted">{{ $product->created_at->format('H:i') }}</span>
                                </small>
                            </td>
                            <td class="table-actions">
                                <div class="btn-group btn-group-sm">
                                    @if($product->trashed())
                                        <form action="{{ route('admin.products.restore', $product->id) }}"
                                              method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success"
                                                    title="Восстановить">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.products.force-delete', $product->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Товар будет полностью удален. Продолжить?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    title="Удалить навсегда">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.products.show', $product) }}"
                                           class="btn btn-info" title="Просмотр">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           class="btn btn-warning" title="Редактировать">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}"
                                              method="POST"
                                              onsubmit="return confirm('Переместить товар в корзину?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    title="Удалить">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="bi bi-box display-4 text-muted"></i>
                                <h5 class="mt-3">Товары не найдены</h5>
                                <p class="text-muted">Создайте первый товар или измените параметры поиска</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Добавить товар
                                </a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Показано {{ $products->firstItem() }} - {{ $products->lastItem() }} из {{ $products->total() }} товаров
                </div>
                <nav>
                    {{ $products->withQueryString()->links() }}
                </nav>
            </div>
        </div>
    </div>

    <!-- Статистика -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6 class="card-title">Всего товаров</h6>
                    <h2 class="card-text">{{ App\Models\Product::count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h6 class="card-title">Активных</h6>
                    <h2 class="card-text">{{ App\Models\Product::where('is_active', true)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h6 class="card-title">Рекомендуемых</h6>
                    <h2 class="card-text">{{ App\Models\Product::where('is_featured', true)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h6 class="card-title">Нет в наличии</h6>
                    <h2 class="card-text">{{ App\Models\Product::where('stock', 0)->count() }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
