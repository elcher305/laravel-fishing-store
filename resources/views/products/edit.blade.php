@extends('layouts.admin')

@section('title', 'Редактирование товара')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>
                <i class="bi bi-box"></i> Редактирование товара
            </h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Название товара *</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $product->name) }}"
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
                                      rows="3">{{ old('description', $product->description) }}</textarea>
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
                                       value="{{ old('price', $product->price) }}"
                                       required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Количество *</label>
                                <input type="number"
                                       min="0"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       id="quantity"
                                       name="quantity"
                                       value="{{ old('quantity', $product->quantity) }}"
                                       required>
                                @error('quantity')
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
                                <option value="Удилища" {{ old('category', $product->category) == 'Удилища' ? 'selected' : '' }}>Удилища</option>
                                <option value="Катушки" {{ old('category', $product->category) == 'Катушки' ? 'selected' : '' }}>Катушки</option>
                                <option value="Лески и шнуры" {{ old('category', $product->category) == 'Лески и шнуры' ? 'selected' : '' }}>Лески и шнуры</option>
                                <option value="Крючки" {{ old('category', $product->category) == 'Крючки' ? 'selected' : '' }}>Крючки</option>
                                <option value="Приманки" {{ old('category', $product->category) == 'Приманки' ? 'selected' : '' }}>Приманки</option>
                                <option value="Грузила и поплавки" {{ old('category', $product->category) == 'Грузила и поплавки' ? 'selected' : '' }}>Грузила и поплавки</option>
                                <option value="Экипировка" {{ old('category', $product->category) == 'Экипировка' ? 'selected' : '' }}>Экипировка</option>
                                <option value="Аксессуары" {{ old('category', $product->category) == 'Аксессуары' ? 'selected' : '' }}>Аксессуары</option>
                                <option value="Наживка" {{ old('category', $product->category) == 'Наживка' ? 'selected' : '' }}>Наживка</option>
                                <option value="Другое" {{ old('category', $product->category) == 'Другое' ? 'selected' : '' }}>Другое</option>
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Фото товара</label>

                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="Текущее фото"
                                         class="img-thumbnail"
                                         style="max-width: 200px;">
                                    <p class="small text-muted mt-1">Текущее фото</p>
                                </div>
                            @endif

                            <input type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   id="image"
                                   name="image"
                                   accept="image/*">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
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
                        @php
                            $characteristics = $product->characteristics ?? [];
                            $charIndex = 0;
                        @endphp

                        @if(!empty($characteristics))
                            @foreach($characteristics as $char)
                                <div class="row mb-2 characteristic-row">
                                    <div class="col-md-5">
                                        <input type="text"
                                               class="form-control"
                                               name="characteristics[{{ $charIndex }}][key]"
                                               value="{{ $char['key'] }}"
                                               placeholder="Характеристика">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text"
                                               class="form-control"
                                               name="characteristics[{{ $charIndex }}][value]"
                                               value="{{ $char['value'] }}"
                                               placeholder="Значение">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-characteristic">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @php $charIndex++; @endphp
                            @endforeach
                        @else
                            <div class="row mb-2 characteristic-row">
                                <div class="col-md-5">
                                    <input type="text"
                                           class="form-control"
                                           name="characteristics[0][key]"
                                           placeholder="Характеристика">
                                </div>
                                <div class="col-md-5">
                                    <input type="text"
                                           class="form-control"
                                           name="characteristics[0][value]"
                                           placeholder="Значение">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-characteristic">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Назад к списку
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Обновить товар
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let charIndex = {{ $charIndex }};

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
