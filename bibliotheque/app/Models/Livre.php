<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livre extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'titre',
        'auteur',
        'annee_publication',
        'description'
    ];
}
