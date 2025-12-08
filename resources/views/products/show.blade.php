@extends('layouts.admin')

@section('title', $product->name)

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-eye"></i> Просмотр товара
            </h4>
            <div class="btn-group">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Редактировать
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Назад
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="img-fluid rounded mb-3">
                    @endif

                    <ul class="list-unstyled">
                        <li><strong>ID:</strong> {{ $product->id }}</li>
                        <li><strong>Категория:</strong> {{ $product->category }}</li>
                        <li><strong>Цена:</strong> {{ $product->price }} ₽</li>
                        <li><strong>Количество:</strong> {{ $product->quantity }} шт.</li>
                        <li><strong>Статус:</strong> {{ $product->is_active ? 'Активен' : 'Не активен' }}</li>
                    </ul>
                </div>

                <div class="col-md-8">
                    <h2>{{ $product->name }}</h2>

                    @if($product->description)
                        <div class="mb-3">
                            <h5>Описание</h5>
                            <p>{{ $product->description }}</p>
                        </div>
                    @endif

                    @if(!empty($product->characteristics))
                        <div class="mb-3">
                            <h5>Характеристики</h5>
                            <table class="table table-striped">
                                <tbody>
                                @foreach($product->characteristics as $char)
                                    <tr>
                                        <th>{{ $char['key'] }}</th>
                                        <td>{{ $char['value'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
