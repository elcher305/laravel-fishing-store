<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Получить роль пользователя
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Получить корзину пользователя
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Получить адреса пользователя
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Получить заказы пользователя
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Получить отзывы пользователя
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Получить избранные товары пользователя
     */
    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Получить адрес по умолчанию
     */
    public function defaultAddress(): HasOne
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    /**
     * Проверить, является ли пользователь администратором
     */
    public function isAdmin(): bool
    {
        return $this->role_id === 1; // ID админа из seeds
    }

    /**
     * Проверить, является ли пользователь обычным пользователем
     */
    public function isUser(): bool
    {
        return $this->role_id === 2; // ID пользователя из seeds
    }

    /**
     * Получить количество товаров в корзине
     */
    public function cartItemsCount(): int
    {
        return $this->cartItems()->count();
    }

    /**
     * Получить общую стоимость корзины
     */
    public function cartTotal(): float
    {
        return $this->cartItems()->with('product')->get()->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * Проверить, есть ли товары в корзине
     */
    public function hasCartItems(): bool
    {
        return $this->cartItems()->exists();
    }

    /**
     * Получить последний заказ пользователя
     */
    public function lastOrder()
    {
        return $this->orders()->latest()->first();
    }

    /**
     * Получить статистику заказов пользователя
     */
    public function orderStats(): array
    {
        return [
            'total' => $this->orders()->count(),
            'pending' => $this->orders()->where('status', 'pending')->count(),
            'delivered' => $this->orders()->where('status', 'delivered')->count(),
            'total_spent' => $this->orders()->where('status', 'delivered')->sum('total'),
        ];
    }

    /**
     * Валидационные правила для профиля
     */
    public static function profileRules($userId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $userId,
        ];
    }

    /**
     * Валидационные правила для смены пароля
     */
    public static function passwordRules(): array
    {
        return [
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Событие при создании пользователя
     */
    protected static function boot()
    {
        parent::boot();

        // При создании пользователя, создаем для него адрес по умолчанию
        static::created(function ($user) {
            if ($user->role_id === 2) { // Только для обычных пользователей
                $user->addresses()->create([
                    'title' => 'Основной адрес',
                    'full_name' => $user->name,
                    'phone' => $user->phone ?? '+7 (999) 999-99-99',
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
        });

        // При удалении пользователя, удаляем связанные данные
        static::deleting(function ($user) {
            $user->cartItems()->delete();
            $user->addresses()->delete();
            $user->reviews()->delete();
            $user->wishlist()->delete();

            // Для заказов только обнуляем user_id, чтобы сохранить историю
            $user->orders()->update(['user_id' => null]);
        });
    }
}
