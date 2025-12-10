@extends('layouts.admin')

@section('title', 'Товары')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Товары</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">Добавить товар</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Изображение</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                        @else
                            <span class="text-muted">Нет фото</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price, 2) }} ₽</td>
                    <td>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">Редактировать</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Удалить товар?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
@endsection
