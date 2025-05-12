<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des commandes (orders).
 *
 * Relations :
 * - user : utilisateur ayant passé la commande
 * - items : articles de la commande
 * - payments : paiements associés
 * - commission : commission prélevée sur la commande
 * - shipments : expéditions associées
 * - coupons : coupons utilisés
 * - returns : retours associés
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'total_amount', 'commission_amount', 'payment_method', 'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function commission()
    {
        return $this->hasOne(Commission::class);
    }
    public function shipments()
    {
        return $this->hasMany(OrderShipment::class);
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'order_coupons');
    }
    public function returns()
    {
        return $this->hasMany(Returns::class);
    }
}

/**
 * Article d'une commande (order_items).
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'variant_id', 'quantity', 'unit_price', 'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}

/**
 * Paiement associé à une commande.
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'amount', 'method', 'status', 'transaction_id', 'paid_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

/**
 * Commission prélevée sur une commande.
 */
class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'amount', 'collected'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

/**
 * Expédition d'une commande.
 */
class OrderShipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'shipping_method_id', 'tracking_number', 'status', 'shipped_at', 'delivered_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }
}

/**
 * Coupon de réduction.
 */
class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_type', 'discount_value', 'max_usage', 'used_count', 'expires_at', 'is_active'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_coupons');
    }
}

/**
 * Liaison coupon/commande (order_coupons).
 */
class OrderCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'coupon_id', 'discount_applied'
    ];
}

/**
 * Retour/Remise associé à une commande.
 */
class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'user_id', 'reason', 'status', 'refund_amount'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

/**
 * Transaction financière (journal).
 */
class FinancialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'type', 'amount', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

/**
 * Adresse de livraison.
 */
class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'full_name', 'phone', 'address', 'city', 'country', 'postal_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

/**
 * Méthode de livraison.
 */
class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price'
    ];

    public function shipments()
    {
        return $this->hasMany(OrderShipment::class);
    }
}
