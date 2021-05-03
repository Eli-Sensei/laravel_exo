<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository 
{
    protected function queryActive(){
        return Post::select(
            "id",
            "slug",
            'image',
            "title",
            "excerpt",
            "user_id")
            ->with('user:id,name')
            ->whereActive(true);
    }

    protected function queryActiveOrderByDate()
    {
        return $this->queryActive()->latest();
    }

    public function getActiveOrderByDate($nbPages)
    {
        return $this->queryActiveOrderByDate()->paginate($nbPages);
    }

    public function getHeroes(){
        return $this->queryActive()->with("categories")->latest("updated_at")->take(5)->get();
    }

    public function getPostBySlug($slug)
    {
        // Post par slug avec l'utilisateur, les tags et les catégories associé
        $post = Post::with(
            "user:id,name,email",
            "tags:id,tag,slug",
            "categories:title,slug"
        )
        ->withCount("validComments")
        ->whereSlug($slug)
        ->firstOrFail();

        // Porst précédent
        $post->previous = $this->getPreviousPost($post->id);
        // Post suivant
        $post->previous = $this->getNextPost($post->id);

        return $post;
    }

    public function getPreviousPost($id)
    {
        return Post::select("title", "slug")
                ->whereActive(true)
                ->latest('id')
                ->firstWhere("id", '<', $id);
    }

    public function getNextPost($id)
    {
        return Post::select("title", "slug")
                ->whereActive(true)
                ->oldest('id')
                ->firstWhere("id", '>', $id);
    }
}