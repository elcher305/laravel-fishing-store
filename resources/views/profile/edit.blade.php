{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.profile')

@section('title', 'Редактирование профиля')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Редактирование профиля</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="mb-3">
                                    <img src="{{ $user->avatar_url }}"
                                         alt="Аватар"
                                         class="img-thumbnail rounded-circle"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                </div>

                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Аватарка</label>
                                    <input type="file"
                                           class="form-control @error('avatar') is-invalid @enderror"
                                           id="avatar"
                                           name="avatar"
                                           accept="image/*">
                                    @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Макс. 2MB. Форматы: JPG, PNG, GIF</small>
                                </div>

                                @if($user->avatar)
                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="if(confirm('Удалить аватарку?')) document.getElementById('delete-avatar-form').submit()">
                                        <i class="bi bi-trash"></i> Удалить аватарку
                                    </button>
                                @endif
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Имя *</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name', $user->name) }}"
                                               required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email', $user->email) }}"
                                               required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Телефон</label>
                                        <input type="tel"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               id="phone"
                                               name="phone"
                                               value="{{ old('phone', $user->phone) }}"
                                               placeholder="+7 (999) 123-45-67">
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="birth_date" class="form-label">Дата рождения</label>
                                        <input type="date"
                                               class="form-control @error('birth_date') is-invalid @enderror"
                                               id="birth_date"
                                               name="birth_date"
                                               value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}">
                                        @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="form-label">Пол</label>
                                        <select class="form-select @error('gender') is-invalid @enderror"
                                                id="gender"
                                                name="gender">
                                            <option value="">Не указан</option>
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Мужской</option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Женский</option>
                                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Другой</option>
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fishing_experience" class="form-label">Опыт в рыбалке *</label>
                                        <select class="form-select @error('fishing_experience') is-invalid @enderror"
                                                id="fishing_experience"
                                                name="fishing_experience"
                                                required>
                                            <option value="beginner" {{ old('fishing_experience', $user->fishing_experience) == 'beginner' ? 'selected' : '' }}>Начинающий</option>
                                            <option value="amateur" {{ old('fishing_experience', $user->fishing_experience) == 'amateur' ? 'selected' : '' }}>Любитель</option>
                                            <option value="professional" {{ old('fishing_experience', $user->fishing_experience) == 'professional' ? 'selected' : '' }}>Профессионал</option>
                                        </select>
                                        @error('fishing_experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="favorite_fishing_type" class="form-label">Любимый вид ловли</label>
                                    <input type="text"
                                           class="form-control @error('favorite_fishing_type') is-invalid @enderror"
                                           id="favorite_fishing_type"
                                           name="favorite_fishing_type"
                                           value="{{ old('favorite_fishing_type', $user->favorite_fishing_type) }}"
                                           placeholder="Например: Спиннинг, Фидер, Поплавок">
                                    @error('favorite_fishing_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Адрес</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="2">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="about" class="form-label">Обо мне</label>
                                    <textarea class="form-control @error('about') is-invalid @enderror"
                                              id="about"
                                              name="about"
                                              rows="3"
                                              placeholder="Расскажите о своем опыте в рыбалке...">{{ old('about', $user->about) }}</textarea>
                                    @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Отмена
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Сохранить изменения
                            </button>
                        </div>
                    </form>

                    <form id="delete-avatar-form"
                          action="{{ route('profile.avatar.delete') }}"
                          method="POST"
                          style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
