<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'age',
        'adresse',
        'telephone',
        'email',
        'whatsapp',
        'profession',
        'sexe',
        'urgencecontact',
        'autre',
        'situationmatrimoniale',
    ];

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function arrondissement()
    {
        return $this->belongsTo(Arrondissement::class);
    }

    public function quartier()
    {
        return $this->belongsTo(Quartier::class);
    }

    // public function situationMatrimoniale()
    // {
    //     return $this->belongsTo(SituationMatrimoniale::class);
    // }
}
