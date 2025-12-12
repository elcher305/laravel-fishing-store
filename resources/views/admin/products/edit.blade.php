@extends('admin.layouts.app')

@section('title', 'Редактировать товар')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-edit"></i> Редактировать товар
        </h1>
        <div class="btn-group">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> Просмотр
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Основная информация -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Основная информация</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Название товара *</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Описание</label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="4">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Категория</label>
                                            <input type="text" class="form-control" id="category" name="category"
                                                   value="{{ old('category', $product->category) }}">
                                            @error('category')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="brand" class="form-label">Бренд</label>
                                            <input type="text" class="form-control" id="brand" name="brand"
                                                   value="{{ old('brand', $product->brand) }}">
                                            @error('brand')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Характеристики -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Характеристики</h5>
                            </div>
                            <div class="card-body">
                                <div id="specifications-container">
                                    @php
                                        $specs = $product->specs_array;
                                    @endphp

                                    @if(!empty($specs))
                                        @foreach($specs as $key => $value)
                                            <div class="row g-2 mb-2 specification-row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="spec_keys[]"
                                                           value="{{ $key }}" placeholder="Например: Материал">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="spec_values[]"
                                                           value="{{ $value }}" placeholder="Например: Нержавеющая сталь">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger w-100 remove-spec">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row g-2 mb-2 specification-row">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="spec_keys[]"
                                                       placeholder="Например: Материал">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="spec_values[]"
                                                       placeholder="Например: Нержавеющая сталь">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger w-100 remove-spec" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-primary mt-2" id="add-spec">
                                    <i class="fas fa-plus"></i> Добавить характеристику
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Правая колонка -->
                    <div class="col-md-4">
                        <!-- Цены и наличие -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Цены и наличие</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Цена *</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" id="price"
                                               name="price" value="{{ old('price', $product->price) }}" required min="0">
                                        <span class="input-group-text">₽</span>
                                    </div>
                                    @error('price')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="stock" class="form-label">Количество *</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                           value="{{ old('stock', $product->stock) }}" required min="0">
                                    @error('stock')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active"
                                           name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Активный товар</label>
                                </div>
                            </div>
                        </div>

                        <!-- Изображение -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Изображение товара</h5>
                            </div>
                            <div class="card-body">
                                @if($product->image)
                                    <div class="text-center mb-3">
                                        <img src="{{ $product->image_url }}" class="img-thumbnail" style="max-width: 200px;">
                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                                                <label class="form-check-label text-danger" for="remove_image">
                                                    Удалить изображение
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        {{ $product->image ? 'Загрузить новое изображение' : 'Загрузить изображение' }}
                                    </label>
                                    <input type="file" class="form-control" id="image" name="image"
                                           accept="image/*">
                                    <small class="text-muted">Оставьте пустым, чтобы не изменять</small>
                                    @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="image-preview" class="mt-3 text-center"></div>
                            </div>
                        </div>

                        <!-- Кнопки действий -->
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success w-100 mb-2">
                                    <i class="fas fa-save"></i> Сохранить изменения
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-times"></i> Отмена
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/edit.js') }}"></script>
@endsection

