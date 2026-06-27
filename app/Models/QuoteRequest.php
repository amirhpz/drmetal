<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequest extends Model
{
    protected $fillable = [
        'product_id',
        'company_name',
        'contact_person',
        'phone',
        'email',
        'quantity',
        'message',
        'status',
        'ip_address',
        'user_agent',
        'admin_note',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
