<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Relacionamento 1:N com a tabela charges
    public function charges()
    {
        return $this->hasMany(Charge::class); // Um cliente pode ter várias cobranças
    }
}
