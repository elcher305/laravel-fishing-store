@extends('admin.layouts.app')

@section('title', $product->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-box"></i> {{ $product->name }}
        </h1>
        <div class="btn-group">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Редактировать
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Информация о товаре</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="img-fluid rounded mb-3">
                        </div>

                        <div class="col-md-8">
                            <table class="table table-sm">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td>{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <th>Название:</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Категория:</th>
                                    <td>{{ $product->category ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Бренд:</th>
                                    <td>{{ $product->brand ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Цена:</th>
                                    <td><strong>{{ number_format($product->price, 0, ',', ' ') }} ₽</strong></td>
                                </tr>
                                <tr>
                                    <th>Наличие:</th>
                                    <td>
                                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->stock }} шт.
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Статус:</th>
                                    <td>
                                    <span class="badge bg-{{ $product->status_class }}">
                                        {{ $product->status }}
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Создан:</th>
                                    <td>{{ $product->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Обновлен:</th>
                                    <td>{{ $product->updated_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Описание -->
                    @if($product->description)
                        <div class="mt-4">
                            <h6>Описание</h6>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Характеристики -->
                    @if(!empty($product->specs_array))
                        <div class="mt-4">
                            <h6>Характеристики</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <tbody>
                                    @foreach($product->specs_array as $key => $value)
                                        <tr>
                                            <th width="30%">{{ $key }}</th>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Боковая панель -->
        <div class="col-md-4">
            <!-- Быстрые действия -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Быстрые действия</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.show', $product) }}" target="_blank"
                           class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt"></i> Посмотреть на сайте
                        </a>

                        <button type="button" class="btn btn-outline-danger"
                                onclick="confirmDelete()">
                            <i class="fas fa-trash"></i> Удалить товар
                        </button>

                        <form id="delete-form" action="{{ route('admin.products.destroy', $product) }}"
                              method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>

            <!-- Статистика -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Статистика</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Просмотры:</span>
                            <span class="badge bg-secondary">0</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Продажи:</span>
                            <span class="badge bg-success">0</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>В корзинах:</span>
                            <span class="badge bg-warning">0</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>В избранном:</span>
                            <span class="badge bg-info">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete() {
            if (confirm('Вы уверены, что хотите удалить этот товар?')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endpush
