@extends('layouts.admin')

@section('title', 'Добавление товара')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>
                <i class="bi bi-box"></i> Добавление нового товара
            </h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Название товара *</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Цена (₽) *</label>
                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       class="form-control @error('price') is-invalid @enderror"
                                       id="price"
                                       name="price"
                                       value="{{ old('price', '0') }}"
                                       required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Категория *</label>
                            <select class="form-select @error('category') is-invalid @enderror"
                                    id="category"
                                    name="category"
                                    required>
                                <option value="">Выберите категорию</option>
                                <option value="Удилища" {{ old('category') == 'Удилища' ? 'selected' : '' }}>Удилища</option>
                                <option value="Катушки" {{ old('category') == 'Катушки' ? 'selected' : '' }}>Катушки</option>
                                <option value="Лески и шнуры" {{ old('category') == 'Лески и шнуры' ? 'selected' : '' }}>Лески и шнуры</option>
                                <option value="Крючки" {{ old('category') == 'Крючки' ? 'selected' : '' }}>Крючки</option>
                                <option value="Приманки" {{ old('category') == 'Приманки' ? 'selected' : '' }}>Приманки</option>
                                <option value="Грузила и поплавки" {{ old('category') == 'Грузила и поплавки' ? 'selected' : '' }}>Грузила и поплавки</option>
                                <option value="Экипировка" {{ old('category') == 'Экипировка' ? 'selected' : '' }}>Экипировка</option>
                                <option value="Аксессуары" {{ old('category') == 'Аксессуары' ? 'selected' : '' }}>Аксессуары</option>
                                <option value="Наживка" {{ old('category') == 'Наживка' ? 'selected' : '' }}>Наживка</option>
                                <option value="Другое" {{ old('category') == 'Другое' ? 'selected' : '' }}>Другое</option>
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Фото товара</label>
                            <input type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   id="image"
                                   name="image"
                                   accept="image/*">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Макс. размер: 2MB. Форматы: JPG, PNG, GIF</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       checked>
                                <label class="form-check-label" for="is_active">Товар активен</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-list-check"></i> Характеристики
                            <button type="button" class="btn btn-sm btn-outline-primary float-end" id="addCharacteristic">
                                <i class="bi bi-plus"></i> Добавить
                            </button>
                        </h5>
                    </div>
                    <div class="card-body" id="characteristics-container">
                        <div class="row mb-2 characteristic-row">
                            <div class="col-md-5">
                                <input type="text"
                                       class="form-control"
                                       name="characteristics[0][key]"
                                       placeholder="Характеристика (напр., Длина)">
                            </div>
                            <div class="col-md-5">
                                <input type="text"
                                       class="form-control"
                                       name="characteristics[0][value]"
                                       placeholder="Значение (напр., 2.4 м)">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-characteristic">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Назад к списку
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Добавить товар
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let charIndex = 1;

            document.getElementById('addCharacteristic').addEventListener('click', function() {
                const container = document.getElementById('characteristics-container');
                const row = document.createElement('div');
                row.className = 'row mb-2 characteristic-row';
                row.innerHTML = `
            <div class="col-md-5">
                <input type="text"
                       class="form-control"
                       name="characteristics[${charIndex}][key]"
                       placeholder="Характеристика">
            </div>
            <div class="col-md-5">
                <input type="text"
                       class="form-control"
                       name="characteristics[${charIndex}][value]"
                       placeholder="Значение">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-characteristic">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
                container.appendChild(row);
                charIndex++;
            });

            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-characteristic')) {
                    const row = e.target.closest('.characteristic-row');
                    if (document.querySelectorAll('.characteristic-row').length > 1) {
                        row.remove();
                    }
                }
            });
        });
    </script>
@endpush
