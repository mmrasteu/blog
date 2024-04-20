<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        //Revisar si el usuario autenticado es el mismo que creo el articulo
        return ($user->id === $article->user_id) ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        return ($user->id === $article->user_id) ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        return ($user->id === $article->user_id) ? true : false;
    }

    /**
     * Determina si el usuario puede ver un articulo publico
     */
    public function published(?User $user, Article $article): bool
    {
        if($article->status == 1) {
            return true;
        } else {
            return false;
        }
    }
}
