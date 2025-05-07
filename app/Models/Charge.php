<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Charge extends Model
{
    protected $fillable = [
        'client_id',
        'description',
        'value',
        'status',
        'expiration',
        // Outros campos do seu model Charge
    ];

    /**
     * Get the client that owns the charge.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}