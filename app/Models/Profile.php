<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    //guarded contratio a filleable. 
    //Aqui ponemos lo que NO queremos asignar masivamete
    //Con esto se protege de SQL injection entre otros ataques
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relacion nde 1:1 inversa (profile-user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
