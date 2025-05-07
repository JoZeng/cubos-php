<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    // Defina os campos que podem ser atribuídos em massa
    protected $fillable = [
        'client_id', 'description', 'expiration', 'value', 'status', // Adicione 'description' aqui
    ];

    // Se você tiver campos que não devem ser preenchidos em massa, use $guarded
    // protected $guarded = ['id'];  // Isso impede que o campo 'id' seja preenchido automaticamente
}
