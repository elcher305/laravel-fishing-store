@extends('admin.layouts.app')

@section('title', 'Редактировать товар: ' . $product->name)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">
                <i class="bi bi-pencil"></i> Редактировать товар
            </h2>
            <div>
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info">
                    <i class="bi bi-eye"></i> Просмотр
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Назад
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('admin.products.partials.form')

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            Отмена
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Обновить товар
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
