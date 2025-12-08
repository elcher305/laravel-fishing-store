@extends('layouts.admin')

@section('title', 'Каталог товаров')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-box-seam"></i> Каталог товаров</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Добавить товар
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Фото</th>
                            <th>Название</th>
                            <th>Категория</th>
                            <th>Цена</th>
                            <th>Кол-во</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div style="width: 60px; height: 60px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong><br>
                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $product->category }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $product->price }} ₽</span>
                                </td>
                                <td>
                                    @if($product->quantity > 0)
                                        <span class="badge bg-success">{{ $product->quantity }} шт.</span>
                                    @else
                                        <span class="badge bg-danger">Нет в наличии</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Активен</span>
                                    @else
                                        <span class="badge bg-warning">Не активен</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="btn btn-outline-primary" title="Редактировать">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}"
                                              method="POST"
                                              onsubmit="return confirm('Удалить товар?')"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Удалить">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $products->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Товаров пока нет</h4>
                    <p class="text-muted">Добавьте первый товар в каталог</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Добавить товар
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
