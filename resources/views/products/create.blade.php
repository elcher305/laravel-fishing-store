{{-- create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Добавить товар')

@section('content')
    <h1>Добавить новый товар</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Название товара *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Цена *</label>
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                       id="price" name="price" value="{{ old('price') }}" required>
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


        </div>



        <div class="mb-3">
            <label for="image" class="form-label">Изображение товара</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror"
                   id="image" name="image" accept="image/*">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
            <label class="form-check-label" for="is_active">Товар активен</label>
        </div>

        <button type="submit" class="btn btn-primary">Добавить товар</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
@endsection
