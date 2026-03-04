<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $table = 'receipts';
    protected $primaryKey = 'receipt_id';

    protected $fillable = [
        'user_id',
        'checkout_id',
        'receipt_number',
        'payment_method',
        'payment_reference',
        'paid_amount',
        'paid_at',
    ];

    protected $dates = [
        'paid_at',
        'created_at',
        'updated_at',
    ];
}
