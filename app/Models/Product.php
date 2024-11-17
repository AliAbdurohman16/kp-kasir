<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'products';

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
            ->useLogName('Produk')
            ->logUnguarded()
            ->setDescriptionForEvent(function (string $eventName) {
                if ($eventName == 'created') {
                    return 'Tambah Produk';
                } else if ($eventName == 'updated') {
                    return 'Ubah Produk';
                } else if ($eventName == 'deleted') {
                    return 'Hapus Produk';
                }
            });
    }

    public function Carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
}
