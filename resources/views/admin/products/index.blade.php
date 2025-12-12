@extends('admin.layouts.app')

@section('title', 'Управление товарами')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-box"></i> Управление товарами
        </h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Добавить товар
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4>Товаров пока нет</h4>
                    <p class="text-muted">Добавьте первый товар</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Добавить товар
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th width="60">#</th>
                            <th width="100">Фото</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Наличие</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                         class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    <div class="text-muted small">
                                        {{ $product->category }}
                                        @if($product->brand)
                                            • {{ $product->brand }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ number_format($product->price, 0, ',', ' ') }} ₽</strong>
                                </td>
                                <td>
                                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->stock }} шт.
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $product->status_class }}">
                                        {{ $product->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.products.show', $product) }}"
                                           class="btn btn-info" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           class="btn btn-primary" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $product->id }})" title="Удалить">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <form id="delete-form-{{ $product->id }}"
                                          action="{{ route('admin.products.destroy', $product) }}"
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Пагинация -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(productId) {
            if (confirm('Вы уверены, что хотите удалить этот товар?')) {
                document.getElementById('delete-form-' + productId).submit();
            }
        }
    </script>
@endpush
