<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class Order
 * @package App\Models
 * @version April 24, 2021, 2:20 am UTC
 *
 * @property \App\Models\User $user
 * @property string $customer_name
 * @property string $customer_email
 * @property string $customer_mobile
 * @property string $status
 * @property integer $user_id
 */
class Order extends Model
{

    use HasFactory;

    public $table = 'orders';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const ORDER_CREATED = 'CREATED';
    const ORDER_PAYED = 'PAYED';
    const ORDER_REJECTED = 'REJECTED';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'customer_name' => 'string',
        'customer_email' => 'string',
        'customer_mobile' => 'string',
        'status' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer_name' => 'required|string|max:80',
        'customer_email' => 'required|string|max:120',
        'customer_mobile' => 'required|string|max:40',
        'status' => 'nullable|string|max:20',
        'user_id' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            $item->user_id = Auth::user()->id;
            $item->status = self::ORDER_CREATED;
        });
    }
}
