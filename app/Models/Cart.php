<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Cart extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'carts';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Keranjang')
            ->logUnguarded()
            ->setDescriptionForEvent(function (string $eventName) {
                if ($eventName == 'created') {
                    return 'Tambah Keranjang';
                } else if ($eventName == 'updated') {
                    return 'Ubah Keranjang';
                } else if ($eventName == 'deleted') {
                    return 'Hapus Keranjang';
                }
            });
    }

    public function CartDetails()
    {
        return $this->hasMany(CartDetail::class, 'cart_id');
    }

    public function Transactions()
    {
        return $this->hasMany(Transaction::class, 'product_id');
    }
}
