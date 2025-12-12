<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'full_name',
        'phone',
        'country',
        'region',
        'city',
        'street',
        'house',
        'apartment',
        'postal_code',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Получить пользователя, которому принадлежит адрес
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить заказы, использующие этот адрес
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Получить полный адрес в виде строки
     */
    public function getFullAddressAttribute(): string
    {
        $parts = [
            $this->country,
            $this->region,
            $this->city,
            $this->street . ', д. ' . $this->house,
            $this->apartment ? 'кв. ' . $this->apartment : null,
            'индекс: ' . $this->postal_code,
        ];

        return implode(', ', array_filter($parts, function($part) {
            return !empty($part);
        }));
    }

    /**
     * Получить адрес для доставки (с именем получателя)
     */
    public function getDeliveryAddressAttribute(): string
    {
        $parts = [
            $this->full_name,
            'тел: ' . $this->phone,
            $this->full_address,
        ];

        return implode(', ', array_filter($parts));
    }

    /**
     * Получить краткий адрес (город, улица, дом)
     */
    public function getShortAddressAttribute(): string
    {
        $parts = [
            $this->city,
            'ул. ' . $this->street . ', д. ' . $this->house,
            $this->apartment ? 'кв. ' . $this->apartment : null,
        ];

        return implode(', ', array_filter($parts));
    }

    /**
     * Получить адрес для карты
     */
    public function getMapAddressAttribute(): string
    {
        return $this->city . ', ' . $this->street . ', ' . $this->house;
    }

    /**
     * Проверить, используется ли адрес в заказах
     */
    public function isUsedInOrders(): bool
    {
        return $this->orders()->exists();
    }

    /**
     * Проверить, можно ли удалить адрес
     */
    public function canBeDeleted(): bool
    {
        return !$this->isUsedInOrders() && !$this->is_default;
    }

    /**
     * Установить адрес как адрес по умолчанию
     */
    public function setAsDefault(): void
    {
        // Сначала снимаем флаг со всех адресов пользователя
        $this->user->addresses()->update(['is_default' => false]);

        // Затем устанавливаем флаг для текущего адреса
        $this->update(['is_default' => true]);
    }

    /**
     * Scope для получения адресов по умолчанию
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope для получения адресов конкретного пользователя
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope для получения активных адресов (не удаленных)
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Валидационные правила для адреса
     */
    public static function validationRules($addressId = null): array
    {
        return [
            'title' => 'required|string|max:100',
            'full_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|regex:/^[\d\s\-\+\(\)]+$/',
            'country' => 'required|string|max:50',
            'region' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:200',
            'house' => 'required|string|max:10',
            'apartment' => 'nullable|string|max:10',
            'postal_code' => 'required|string|max:10|regex:/^\d{6}$/',
            'is_default' => 'boolean',
        ];
    }

    /**
     * Сообщения об ошибках валидации
     */
    public static function validationMessages(): array
    {
        return [
            'phone.regex' => 'Номер телефона должен содержать только цифры, пробелы, дефисы и скобки.',
            'postal_code.regex' => 'Почтовый индекс должен состоять из 6 цифр.',
            'full_name.required' => 'Укажите ФИО получателя.',
            'street.required' => 'Укажите улицу.',
            'house.required' => 'Укажите номер дома.',
        ];
    }

    /**
     * Создать адрес по умолчанию для пользователя
     */
    public static function createDefaultForUser(User $user): Address
    {
        return self::create([
            'user_id' => $user->id,
            'title' => 'Основной адрес',
            'full_name' => $user->name,
            'phone' => '+7 (999) 999-99-99',
            'country' => 'Россия',
            'region' => 'Томская область',
            'city' => 'Томск',
            'street' => 'Ленина',
            'house' => '237',
            'apartment' => '3',
            'postal_code' => '634050',
            'is_default' => true,
        ]);
    }

    /**
     * Получить список регионов России для выпадающего списка
     */
    public static function getRussianRegions(): array
    {
        return [
            'Московская область',
            'Ленинградская область',
            'Томская область',
            'Новосибирская область',
            'Краснодарский край',
            'Свердловская область',
            'Республика Татарстан',
            'Челябинская область',
            // Добавьте другие регионы по необходимости
        ];
    }

    /**
     * Событие при создании адреса
     */
    protected static function boot()
    {
        parent::boot();

        // При создании адреса, если он помечен как адрес по умолчанию,
        // снимаем флаг с других адресов пользователя
        static::creating(function ($address) {
            if ($address->is_default) {
                $address->user->addresses()->update(['is_default' => false]);
            }
        });

        // При обновлении адреса, если он помечен как адрес по умолчанию,
        // снимаем флаг с других адресов пользователя
        static::updating(function ($address) {
            if ($address->is_default && $address->isDirty('is_default')) {
                $address->user->addresses()
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }
        });

        // При удалении адреса, если он был адресом по умолчанию,
        // назначаем новый адрес по умолчанию (если есть другие адреса)
        static::deleting(function ($address) {
            if ($address->is_default && $address->user->addresses()->count() > 1) {
                $newDefault = $address->user->addresses()
                    ->where('id', '!=', $address->id)
                    ->first();

                if ($newDefault) {
                    $newDefault->update(['is_default' => true]);
                }
            }
        });
    }
}
