@extends('admin.layouts.app')

@section('title', 'Просмотр товара: ' . $product->name)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">
                <i class="bi bi-eye"></i> Просмотр товара
            </h2>
            <div>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Редактировать
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Назад к списку
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Основная информация</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">ID товара:</th>
                                <td>{{ $product->id }}</td>
                            </tr>
                            <tr>
                                <th>Название:</th>
                                <td><strong>{{ $product->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Описание:</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                            <tr>
                                <th>Цена:</th>
                                <td><span class="badge bg-success fs-6">{{ $product->formatted_price }}</span></td>
                            </tr>
                            <tr>
                                <th>Количество на складе:</th>
                                <td>
                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} fs-6">
                                    {{ $product->stock }} шт.
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Дата создания:</th>
                                <td>{{ $product->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Дата обновления:</th>
                                <td>{{ $product->updated_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Изображение</h5>
                    </div>
                    <div class="card-body text-center">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="img-fluid rounded" style="max-height: 300px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                 style="height: 200px;">
                                <i class="bi bi-image text-muted display-4"></i>
                            </div>
                            <p class="text-muted mt-2">Изображение не загружено</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Характеристики</h5>
            </div>
            <div class="card-body">
                @if($product->characteristics && count($product->characteristics) > 0)
                    <div class="row">
                        @foreach($product->characteristics as $key => $value)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $key }}</h6>
                                        <p class="card-text">{{ $value }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-list-check display-4 text-muted"></i>
                        <h5 class="mt-3">Характеристики не указаны</h5>
                        <p class="text-muted">Вы можете добавить характеристики при редактировании товара</p>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Добавить характеристики
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-danger"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Удалить товар
                </button>
            </div>
            <div>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Редактировать
                </a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Добавить новый товар
                </a>
            </div>
        </div>
    </div>

    <!-- Modal удаления -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
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
                        Это действие нельзя отменить! Все данные о товаре будут удалены.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Отмена
                    </button>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
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
@endsection
