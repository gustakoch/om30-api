<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacient extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo',
        'full_name',
        'mother_full_name',
        'birth_day',
        'cpf',
        'cns',
        'id_address'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address');
    }
}
