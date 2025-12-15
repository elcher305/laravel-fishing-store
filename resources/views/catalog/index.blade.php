<!-- resources/views/catalog/index.blade.php -->
@extends('layouts.app')

@section('title', 'Каталог товаров')

@section('content')
    <h1>Товары для летней рыбалки</h1>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    @if($product->badge)
                        <div class="card-header">
                            <span class="badge bg-primary">{{ $product->badge }}</span>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>

                        @if($product->sizes)
                            <div class="product-sizes mb-2">
                                @foreach(json_decode($product->sizes) as $size)
                                    <span class="badge bg-secondary me-1 size-badge"
                                          data-size="{{ $size }}">
                                    {{ $size }}
                                </span>
                                @endforeach
                            </div>
                        @endif

                        <p class="card-text">
                            <strong>Цена:</strong> {{ $product->price }} руб.
                        </p>

                        <p class="card-text">
                            @if($product->stock > 5)
                                <span class="text-success">Есть в наличии</span>
                            @elseif($product->stock > 0)
                                <span class="text-warning">Осталось {{ $product->stock }} шт.</span>
                            @else
                                <span class="text-danger">Нет в наличии</span>
                            @endif
                        </p>

                        <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                            @csrf

                            @if($product->stock > 0)
                                @if($product->sizes)
                                    <input type="hidden" name="size" class="selected-size-input" required>
                                    <div class="alert alert-warning size-warning" style="display: none;">
                                        Пожалуйста, выберите размер
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary w-100 add-to-cart-btn"
                                    {{ $product->sizes ? 'disabled' : '' }}>
                                    В корзину
                                </button>
                            @else
                                <button class="btn btn-secondary w-100" disabled>
                                    Нет в наличии
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
