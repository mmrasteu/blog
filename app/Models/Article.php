<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relacion 1:n inversa (article-user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacion 1:n (article-comments)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relacion 1:n inversa (articles-category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    #Utilizar slug en lugar de id
    public function getRouteKeyName() {
        return 'slug';
    }
}
