<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label">Название товара *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание *</label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                      id="description" name="description" rows="4" required>{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Цена (₽) *</label>
                <input type="number" step="0.01" min="0"
                       class="form-control @error('price') is-invalid @enderror"
                       id="price" name="price"
                       value="{{ old('price', $product->price ?? '') }}" required>
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="stock" class="form-label">Количество на складе *</label>
                <input type="number" min="0"
                       class="form-control @error('stock') is-invalid @enderror"
                       id="stock" name="stock"
                       value="{{ old('stock', $product->stock ?? 0) }}" required>
                @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label for="category_id" class="form-label">Категория</label>
        <select class="form-select @error('category_id') is-invalid @enderror"
                id="category_id" name="category_id">
            <option value="">-- Без категории --</option>
            @foreach(App\Models\Category::all() as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="image" class="form-label">Изображение товара</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror"
                   id="image" name="image" accept="image/*">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if(isset($product) && $product->image)
                <div class="mt-2">
                    <p class="mb-1">Текущее изображение:</p>
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                         class="img-thumbnail" style="max-width: 200px;">
                </div>
            @endif

            <div class="mt-2">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i>
                    Поддерживаемые форматы: JPG, PNG, GIF. Макс. размер: 2MB.
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Характеристики товара -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <label class="form-label">Характеристики товара</label>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addCharacteristic">
            <i class="bi bi-plus"></i> Добавить характеристику
        </button>
    </div>

    <div id="characteristics-container">
        @php
            $oldCharacteristics = old('characteristics', []);
            $productCharacteristics = isset($product) && $product->characteristics
                ? $product->characteristics
                : [];

            if (empty($oldCharacteristics['key']) && !empty($productCharacteristics)) {
                $i = 0;
                foreach ($productCharacteristics as $key => $value) {
                    $oldCharacteristics['key'][$i] = $key;
                    $oldCharacteristics['value'][$i] = $value;
                    $i++;
                }
            }

            $characteristicsCount = max(
                count($oldCharacteristics['key'] ?? []),
                count($productCharacteristics)
            );
            $characteristicsCount = $characteristicsCount ?: 1;
        @endphp

        @for($i = 0; $i < $characteristicsCount; $i++)
            <div class="row characteristic-row mb-2">
                <div class="col-md-5">
                    <input type="text" class="form-control"
                           name="characteristics[key][]"
                           placeholder="Название характеристики (например: Цвет)"
                           value="{{ $oldCharacteristics['key'][$i] ?? '' }}">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control"
                           name="characteristics[value][]"
                           placeholder="Значение (например: Красный)"
                           value="{{ $oldCharacteristics['value'][$i] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-characteristic">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        @endfor
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Добавление новой характеристики
            document.getElementById('addCharacteristic').addEventListener('click', function() {
                const container = document.getElementById('characteristics-container');
                const newRow = document.createElement('div');
                newRow.className = 'row characteristic-row mb-2';
                newRow.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control"
                       name="characteristics[key][]"
                       placeholder="Название характеристики">
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control"
                       name="characteristics[value][]"
                       placeholder="Значение">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-outline-danger remove-characteristic">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
                container.appendChild(newRow);
            });

            // Удаление характеристики
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-characteristic')) {
                    e.target.closest('.characteristic-row').remove();
                }
            });
        });
    </script>
@endpush
