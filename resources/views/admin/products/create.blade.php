@extends('admin.layouts.app')

@section('title', 'Добавить товар')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-plus-circle"></i> Добавить товар
        </h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад
        </a>
    </div>
    <script src="{{ asset('js/create.js') }}"></script>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

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
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Описание</label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Категория</label>
                                            <input type="text" class="form-control" id="category" name="category"
                                                   value="{{ old('category') }}">
                                            @error('category')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="brand" class="form-label">Бренд</label>
                                            <input type="text" class="form-control" id="brand" name="brand"
                                                   value="{{ old('brand') }}">
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
                                               name="price" value="{{ old('price', 0) }}" required min="0">
                                        <span class="input-group-text">₽</span>
                                    </div>
                                    @error('price')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="stock" class="form-label">Количество *</label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                           value="{{ old('stock', 0) }}" required min="0">
                                    @error('stock')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active"
                                           name="is_active" value="1" checked>
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
                                <div class="mb-3">
                                    <label for="image" class="form-label">Загрузить изображение</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                           accept="image/*">
                                    <small class="text-muted">Рекомендуемый размер: 800x800px</small>
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
                                    <i class="fas fa-save"></i> Сохранить товар
                                </button>
                                <button type="reset" class="btn btn-secondary w-100">
                                    <i class="fas fa-redo"></i> Сбросить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/create.js') }}"></script>
@endsection


