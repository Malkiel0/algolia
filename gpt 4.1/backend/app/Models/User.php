<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // Champs modifiables en masse (mass assignment)
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'status',
        'avatar', // Chemin ou URL de l'avatar utilisateur
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relations Eloquent
     * ------------------
     */

    /**
     * Commandes passées par l'utilisateur.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Paniers de l'utilisateur.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Adresses de livraison associées à l'utilisateur.
     */
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    /**
     * Transactions financières de l'utilisateur.
     */
    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    /**
     * Retours/Remises demandés par l'utilisateur.
     */
    public function returns()
    {
        return $this->hasMany(Returns::class);
    }

    /**
     * Attributs castés automatiquement.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

