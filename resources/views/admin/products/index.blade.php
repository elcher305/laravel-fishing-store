@extends('admin.layouts.app')

@section('title', 'Управление товарами')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">
                <i class="bi bi-box-seam"></i> Управление товарами
            </h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Добавить товар
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($products->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-box display-1 text-muted"></i>
                        <h4 class="mt-3">Товары не найдены</h4>
                        <p class="text-muted">Добавьте первый товар в магазин</p>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Добавить товар
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Изображение</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Остаток</th>
                                <th>Характеристики</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                 style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <small class="d-block text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    </td>
                                    <td>{{ $product->formatted_price }}</td>
                                    <td>
                                    <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                        {{ $product->stock }} шт.
                                    </span>
                                    </td>
                                    <td>
                                        @if($product->characteristics)
                                            <small>
                                                @foreach(array_slice($product->characteristics, 0, 2) as $key => $value)
                                                    <span class="badge bg-info me-1">{{ $key }}: {{ $value }}</span>
                                                @endforeach
                                                @if(count($product->characteristics) > 2)
                                                    <span class="badge bg-secondary">+{{ count($product->characteristics) - 2 }}</span>
                                                @endif
                                            </small>
                                        @else
                                            <span class="text-muted">Нет</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.products.show', $product) }}"
                                               class="btn btn-info" title="Просмотр">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                               class="btn btn-warning" title="Редактировать">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $product->id }}"
                                                    title="Удалить">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Modal удаления -->
                                        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Подтверждение удаления</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Вы уверены, что хотите удалить товар
                                                        <strong>"{{ $product->name }}"</strong>?
                                                        <p class="text-danger mt-2">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            Это действие нельзя отменить!
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Отмена</button>
                                                        <form action="{{ route('admin.products.destroy', $product) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="bi bi-trash"></i> Удалить
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
