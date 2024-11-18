<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User; // Asegúrate de importar el modelo User

class Chirp extends Model
{
    // Define los atributos que se pueden asignar en masa
    protected $fillable = ['message'];

    // Relación con el modelo User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
