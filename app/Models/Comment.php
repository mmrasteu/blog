<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relacion 1:n inversa (comments-user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacion 1:n inversa (comments-article)
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
