<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'zip_code',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state'
    ];

    public function pacient()
    {
        return $this->belongsTo(Pacient::class);
    }
}
